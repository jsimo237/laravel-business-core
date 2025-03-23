<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcMedia;
use Spatie\Valuestore\Valuestore;

class MediaDeletionRepository
{

    /**
     * @param Valuestore|null $store
     */
    public function __construct(protected ?Valuestore $store = null){

        $this->store ??= Valuestore::make(storage_path('app/medias-deletions.json'));
    }



    public function getContent(){
        return $this->store->all();
    }

    /**
     * @param BcMedia $media
     * @return mixed
     */
    public function addMediaToDelete(BcMedia $media): mixed
    {
        // Put multiple items in one go
      return  $this->store->put($media->toArray());
    }

    /**
     * @param Model $mediable
     * @return array
     */
    public function processToDeleteMedias(Model $mediable) : array{
        $success = false;
        $throwable = null;

        try {
            $storedItems = $this->getContent();

            $items = $this->getMediasForDeletions($mediable);

            $idsToDelete = Arr::pluck($items,["id"]);

            if ($idsToDelete){
                $medias = BcMedia::whereIn("id",$idsToDelete)->get();
                $medias->each(fn($media)=> $media->delete());

                $this->store->flush();

                $newsItems = collect($storedItems)
                            ->filter(fn(array $item)=> !in_array($item["id"],$idsToDelete))
                            ->each(fn(array $item) =>  $this->store->put($item));

                $success = true;

            }

            write_log("medias/deletions", [
                "mediable-id" => $mediable->getKey(),
                "mediable-type" => $mediable->getMorphClass(),
                "items-to-delete" => $items,
                "newsItems"=> $this->getContent()
            ]);

        }catch (\Throwable $exception){
            $throwable = $exception;

            write_log("medias/deletions/errors", [
                "mediable-id" => $mediable->getKey(),
                "mediable-type" => $mediable->getMorphClass(),
                "exception"=> format_exception_message($exception)
            ]);
        }

        return [$success,$throwable];
    }


    public function getMediasForDeletions(Model $mediable){
        $id = $mediable->getKey();
        $type = $mediable->getMorphClass();

        $items =  collect($this->getContent());

        return  $items->filter(function ($item) use ($id,$type){
                            return (
                                ($id == $item["model_id"])
                                &&
                                ($type === $item["model_type"])
                            ) ;
                            }
                        )
                        ->toArray();
    }

}