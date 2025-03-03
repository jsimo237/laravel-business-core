<?php

namespace Kirago\BusinessCore\Modules\MediaManagement\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Media;
use Kirago\BusinessCore\Modules\MediaManagement\Repositories\MediaDeletionRepository;

class MediaController extends Controller
{
    use AuthorizesRequests,DispatchesJobs,ValidatesRequests;


    public function __construct(){

        //  $this->middleware('permission:media-delete')->only(["addToDeletion"]);

    }


    /**
     * @param Media $media
     * @param MediaDeletionRepository $mediaService
     * @return JsonResponse
     */
    public function addToDeletion(Media $media, MediaDeletionRepository $mediaService): JsonResponse
    {

        $mediaService->addMediaToDelete($media);


        return response()->json([
                    'success' => true,
                    'message' => 'Image supprimée temporairement',
                    'medias-deletions' => $mediaService->getContent()
                ]);

    }

}