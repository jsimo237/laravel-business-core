<?php


namespace Kirago\BusinessCore\Modules\CoresManagement\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Traits\Exception;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Traits\Throwable;

trait CanUploadFiles{

    /**
     * @throws Exception|Throwable
     */
    protected function resizeAndConvert(string|UploadedFile $file, ?array $resize = [], ?string $finalExtension = "webp"): string
    {
        $width = $resize['width'] ?? null;
        $height = $resize['height'] ?? null;
        $quality = $resize['quality'] ?? 90;
        $directory = storage_path('app/temp-img-resizes');

        // Vérifier et créer le dossier temporaire si nécessaire
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        // 📌 Gérer le cas où $file est une URL
        $tempPath = null;
        $isTempFile = false;
        if (is_string($file) && filter_var($file, FILTER_VALIDATE_URL)) {
            $tempPath = tempnam(sys_get_temp_dir(), 'img_'); // Fichier temporaire
            file_put_contents($tempPath, file_get_contents($file)); // Télécharger l'image
            $file = new UploadedFile($tempPath, basename($file)); // Convertir en UploadedFile
            $isTempFile = true; // Indique que c'est un fichier temporaire
        }

        // Vérifier si le fichier est valide
        throw_if(!$file instanceof UploadedFile || !$file->isValid(), new \Exception('Le fichier image est invalide.'));

        // Définir les noms et extensions
        $originalExtension = $file->getClientOriginalExtension();
        $imageName = pathinfo($file->hashName(), PATHINFO_FILENAME);

        $finalExtension ??= $originalExtension;

        $path = "{$directory}/{$imageName}.{$finalExtension}";

        // Charger et redimensionner l'image
        $image = Image::make($file->getRealPath());

        if ($width || $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Compression et conversion
        $image->encode($finalExtension, $quality)->save($path);

        // 🗑 Supprimer le fichier temporaire si l'image provient d'une URL
        if ($isTempFile && file_exists($tempPath)) {
            unlink($tempPath);
        }

        return $path;
    }


    /**
     * Télécharge les fichiers et les rattaches au model
     * @param array|UploadedFile|string $images
     * @param array $options
     * @return bool
     * @throws Throwable
     */

    public function uploadFiles(array|UploadedFile|string $images, array $options = []): bool
    {
        try {
            $resize = $options['resize'] ?? [];
            $collectionName = $options['folder'] ?? $this->getMediaCollectionName();

            // S'assurer que $files est bien un tableau
            $images = Arr::wrap($images);

            // Vérification si la liste est vide
            if (empty($images)) {
                return false;
            }

            foreach ($images as $file) {

                // Redimensionnement si nécessaire
                $resizedImagePath = $this->resizeAndConvert($file, $resize); // Remplace le fichier original par la version redimensionnée

                // Enregistrement du fichier dans la collection
                $this->addMedia($resizedImagePath)
                    ->sanitizingFileName(fn(string $fileName) => strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName)))
                    ->preservingOriginal()
                    ->toMediaCollection($collectionName);

                // Suppression du fichier temporaire après traitement
                if ($resizedImagePath) {
                    File::delete($resizedImagePath);
                }
            }

            return true;
        } catch (\Throwable $exception) {
            write_log("uploads/images/{$this->getMorphClass()}",$exception,"error","{$this->getKey()}");
            return false;
        }
    }

}
