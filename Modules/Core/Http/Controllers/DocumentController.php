<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Models\Document;
use Modules\Core\Services\DocumentService;
use Modules\Core\Http\Requests\DocumentRequest;
use Modules\Core\Http\Resources\DocumentResource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @group Document
 */
class DocumentController extends Controller
{

    /**
     * Handle the document business logic
     *
     * @var DocumentService
     */
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Get all the documents
     *
     * @queryParam search string allow the research
     * @queryParam paginate integer add pagination possibility
     *
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        $this->authorize('list', Document::class);

        $documents = $this->documentService->search('path')->get();

        return DocumentResource::collection($documents);
    }

    /**
     * Show a specific document
     *
     * @param Document $document
     *
     * @return DocumentResource
     */
    public function show(Document $document): DocumentResource
    {
        $this->authorize('read', $document);

        return DocumentResource::make($document);
    }

    /**
     * Create a document
     *
     * @bodyParam file File required File to upload
     * @bodyParam documentable_id string required the owner object
     *
     * @param DocumentRequest $request
     *
     * @return JsonResponse
     */
    public function create(DocumentRequest $request): JsonResponse
    {
        $this->authorize('create', Document::class);

        $documentCreated = $this->documentService->create();

        return response()->json([ 'document' => DocumentResource::make($documentCreated) ], Response::HTTP_CREATED);
    }

    /**
     * Delete a document
     *
     * @param Document $document
     *
     * @return Response
     */
    public function delete(Document $document): Response
    {
        $this->authorize('delete', $document);

        $this->documentService->delete($document);

        return response()->noContent();
    }
}
