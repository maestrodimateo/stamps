<?php

namespace Modules\Stamp\Http\Controllers;

use Modules\Stamp\Models\Type;
use Modules\Stamp\Services\TypeService;
use Modules\Stamp\Http\Requests\TypeRequest;
use Modules\Stamp\Http\Resources\TypeResource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function __construct(protected TypeService $typeService)
    {}

    /**
     * Get all the types
     *
     * @queryParam search string allow the research
     * @queryParam paginate integer add pagination possibility
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('list', Type::class);

        $types = $this->typeService->search('label')->get();

        return TypeResource::collection($types);
    }

    /**
     * Show a specific type
     *
     * @param Type $type
     *
     * @return TypeResource
     */
    public function show(Type $type): TypeResource
    {
        $this->authorize('read', $type);

        return TypeResource::make($type);
    }

    /**
     * Create a type
     *
     * @bodyParam example string required
     *
     * @param TypeRequest $request
     *
     * @return JsonResponse
     */
    public function store(TypeRequest $request): JsonResponse
    {
        $this->authorize('create', Type::class);

        $typeCreated = $this->typeService->create();

        return response()->json([
            'type' => TypeResource::make($typeCreated)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a specific type
     *
     * @bodyParam example string required
     *
     * @param TypeRequest $request
     * @param Type $types
     *
     * @return TypeResource
     */
    public function update(TypeRequest $request, Type $type): TypeResource
    {
        $this->authorize('update', $type);

        $this->typeService->update($type);

        return TypeResource::make($type->refresh());
    }

    /**
     * Delete a type
     *
     * @param Type $type
     *
     * @return Response
     */
    public function destroy(Type $type): Response
    {
        $this->authorize('delete', $type);

        $this->typeService->delete($type);

        return response()->noContent();
    }
}
