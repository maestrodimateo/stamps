<?php
namespace Modules\Core\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Models\GeoEntity;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Services\AbstractService;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\GeoEntityRepository;

class GeoEntityService extends AbstractService
{
    /**
     * constructor
     *
     * @param GeoEntityRepository $geoEntityRepository
     * @param Request $request
     */
    public function __construct(GeoEntityRepository $geoEntityRepository, Request $request)
    {
        parent::__construct($geoEntityRepository, $request);
    }

    /**
     * Delete a geographical entity
     * @override
     *
     * @param GeoEntity $geoEntity
     *
     * @return bool|null
     */
    public function delete(Model $geoEntity): bool|null
    {
        return $this->repository->delete($geoEntity);
    }

    /**
     * Add pagination to the request if it exists
     */
    public function get(): Collection|LengthAwarePaginator
    {
        if ($this->request->has('type') && $this->request->filled('type')) {
            $this->repository->builder->where('type', strtoupper($this->request->query('type')));
        }

        return parent::get();
    }
}
