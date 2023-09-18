<?php
namespace Modules\Core\Traits\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

/**
 * @author Noel MEBALE <noel.mebale@aninf.ga>
 * @group Core
 */
trait HandleFile
{

    /**
     * string $field
     *
     * @param FormRequest $request
     * @param string $destinationPath
     * @param string $field
     * @param Model $model
     *
     * @return void
     */
    protected function storeFile(
        FormRequest $request,
        string $destinationPath,
        string $field,
        Model $model = null,
        string $file = 'file'
    )
    {
        if ($request->$file) {
            $path = is_string($request->$file) ?
            $this->storeFileFromBase64($destinationPath, $request) :
            $request->$file->store("public/$destinationPath");

            if ($request->isMethod('PUT')) {
                Storage::delete(optional($model)->$field);
            }

            $request->merge([$field => $path]);
        }
    }

    public function storeManyFiles(
        FormRequest $request,
        string $destinationPath,
        string $field,
        Model $model = null,
    )
    {
        $request->files();
    }

    /**
     * Create an uploaded file object from base 64
     *
     * @return string
     */
    protected function storeFileFromBase64(string $folder, FormRequest $request, string $file = 'file'): string
    {
        $fileCode = explode(';base64,', $request->$file);

        $fileBinary = base64_decode($fileCode[1]);

        $extension = explode('/', $fileCode[0]);

        $filename = uniqid() . '.' .$extension[1];

        $fileFolder = storage_path("app/public/$folder/");

        if (!File::isDirectory($fileFolder)) {
            File::makeDirectory($fileFolder, 0777);
        }

        file_put_contents($fileFolder . $filename, $fileBinary);

        return $folder.'/'. $filename;
    }
}
