<?php
namespace Modules\Stamp\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Stamp\Models\Stamp;

trait StampProjectRelationsTrait
{
    /**
     * Get all of the stamps for a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stamps(): HasMany
    {
        return $this->hasMany(Stamp::class);
    }
}
