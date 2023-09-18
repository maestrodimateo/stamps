<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Modules\Core\Models\GeoEntity;
use App\Http\Controllers\Controller;
use Modules\Core\Services\GeoEntityService;
use Modules\Core\Http\Requests\GeoEntityRequest;
use Modules\Core\Http\Resources\GeoEntityResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Core
 */
class GeoEntityController extends Controller
{
    /**
     * Handle the geo entities business logic
     *
     * @var GeoEntityService
     */
    protected $geoEntityService;

    public function __construct(GeoEntityService $geoEntityService)
    {
        $this->geoEntityService = $geoEntityService;
    }

    /**
     * Get all the geographical entities
     *
     * @queryParam name string location name
     * @queryParam paginate integer add pagination possibility
     * @queryParam type string filter according to type : TOWN, COUNTRY, CONTINENT, DISTRICT
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('list', GeoEntity::class);

        $geoEntities = $this->geoEntityService->fullTextSearch(['parent'])->get();

        return GeoEntityResource::collection($geoEntities);
    }

    /**
     * Show a specific geo entity
     *
     * @param GeoEntity $geoEntity
     *
     * @return GeoEntityResource
     */
    public function show(GeoEntity $geoEntity): GeoEntityResource
    {
        $this->authorize('read', $geoEntity);

        return GeoEntityResource::make($geoEntity->loadMissing(['children']));
    }

    /**
     * Create a geo entity
     *
     * @bodyParam name string required
     * @bodyParam code string country Code ISO
     * @bodyParam type string required The values must be CONTINENT', 'COUNTRY', 'TOWN' or 'DISTRICT'
     * @bodyParam parent_id string The parent geo entity
     *
     * @param GeoEntityRequest $request
     *
     * @return JsonResponse
     */
    public function store(GeoEntityRequest $request): JsonResponse
    {
        $this->authorize('create', GeoEntity::class);

        $newRole = $this->geoEntityService->create();

        return response()->json(GeoEntityResource::make($newRole), Response::HTTP_CREATED);
    }

    /**
     * Update a specific geo entity
     *
     * @bodyParam name string required
     * @bodyParam code string country Code ISO
     * @bodyParam type string required The values must be CONTINENT', 'COUNTRY', 'TOWN' or 'DISTRICT'
     * @bodyParam parent_id string The parent geo entity
     *
     * @param GeoEntityRequest $request
     * @param GeoEntity $geoEntity
     *
     * @return GeoEntityResource
     */
    public function update(GeoEntityRequest $request, GeoEntity $geoEntity): GeoEntityResource
    {
        $this->authorize('update', $geoEntity);

        $this->geoEntityService->update($geoEntity);

        return GeoEntityResource::make($geoEntity->refresh());
    }

    /**
     * Delete a geo entity
     *
     * @param GeoEntity $geoEntity
     *
     * @return bool|null
     */
    public function destroy(GeoEntity $geoEntity)
    {
        $this->authorize('delete', $geoEntity);

        return $this->geoEntityService->delete($geoEntity);
    }
}
