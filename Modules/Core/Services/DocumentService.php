<?php
namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Services\AbstractService;
use \Modules\Core\Repositories\DocumentRepository;

class DocumentService extends AbstractService
{
    /**
     * The model name
     *
     * @var Model
     */
    private Model $model;

    /**
     * The path
     *
     * @var string
     */
    private string $path = 'documents';


    public function __construct(
        DocumentRepository $documentRepository,
        Request $request,
    )
    {
        parent::__construct($documentRepository, $request);
    }

    /**
     * Business logic to reate a document
     *
     * @return Model
     */
    public function create(): Model
    {
        return DB::transaction(function () {

            $this->storeFile($this->request, $this->path, 'path');

            return $this->model->documents()->create([
                'mimetype' => $this->request->file->getClientMimeType(),
                'size' => $this->request->file->getSize(),
            ]);
        });
    }

    /**
     * Delete a document
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function delete(Model $model): bool|null
    {
        return DB::transaction(function () use ($model) {

            Storage::delete($model->path);

            return $this->repository->delete($model);
        });
    }

    /**
     * Set the model name
     *
     * @param Model $model
     *
     * @return self
     */
    public function model(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set the model name
     *
     * @param Model $model
     *
     * @return self
     */
    public function path(string $pathName): self
    {
        $this->path = $pathName;

        return $this;
    }
}
