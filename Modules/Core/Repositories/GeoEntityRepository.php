<?php
namespace Modules\Core\Repositories;

use Illuminate\Http\Response;
use Modules\Core\Models\GeoEntity;
use Modules\Core\Repositories\AbstractRepository;

class GeoEntityRepository extends AbstractRepository
{
    protected string $model = GeoEntity::class;

    /**
     * Check if the geo entity is a country
     *
     * @param string $geoId
     *
     * @return boolean
     */
    public function isCountry(string $geoId): bool
    {
        $geoEntity = $this->builder->find($geoId);

        return $geoEntity->type == GeoEntity::COUNTRY;
    }

    /**
     * Check if the geo entity is a town
     *
     * @param string $geoName
     *
     * @return boolean
     */
    public function isTown(string $geoName): bool
    {
        $geoEntity = $this->builder->search('name', $geoName)->first();

        return $geoEntity->type == GeoEntity::TOWN;
    }
}
