<?php

namespace Modules\Stamp\Http\Controllers;

use Modules\Stamp\Models\Stamp;
use Modules\Stamp\Services\StampService;
use Modules\Stamp\Http\Requests\StampRequest;
use Modules\Stamp\Http\Resources\StampResource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class StampController extends Controller
{
    public function __construct(protected StampService $stampService)
    {}

    /**
     * Get all the stamps
     *
     * @queryParam search string allow the research
     * @queryParam paginate integer add pagination possibility
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('list', Stamp::class);

        $stamps = $this->stampService->search('reference')->get();

        return StampResource::collection($stamps);
    }

    /**
     * Show a specific stamp
     *
     * @param Stamp $stamp
     *
     * @return StampResource
     */
    public function show(Stamp $stamp): StampResource
    {
        $this->authorize('read', $stamp);

        return StampResource::make($stamp);
    }

    /**
     * Create a stamp
     *
     * @bodyParam example string required
     *
     * @param StampRequest $request
     *
     * @return JsonResponse
     */
    public function store(StampRequest $request): JsonResponse
    {
        $this->authorize('create', Stamp::class);

        $stampCreated = $this->stampService->create();

        return response()->json([
            'stamp' => StampResource::make($stampCreated)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a specific stamp
     *
     * @bodyParam example string required
     *
     * @param StampRequest $request
     * @param Stamp $stamps
     *
     * @return StampResource
     */
    public function update(StampRequest $request, Stamp $stamp): StampResource
    {
        $this->authorize('update', $stamp);

        $this->stampService->update($stamp);

        return StampResource::make($stamp->refresh());
    }

    /**
     * Delete a stamp
     *
     * @param Stamp $stamp
     *
     * @return Response
     */
    public function destroy(Stamp $stamp): Response
    {
        $this->authorize('delete', $stamp);

        $this->stampService->delete($stamp);

        return response()->noContent();
    }

    /**
     * Check if the stamp is valid
     *
     * @param Stamp $stamp
     *
     * @return JsonResponse
     */
    public function verify(Stamp $stamp): JsonResponse
    {
        return response()->json(['data' => $stamp->reference]);
    }
}
