<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Traits\Model\HasUuid;
use Modules\Core\Traits\Model\WithSearch;

class GeoEntity extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = [
        "name",
        "type",
        "code",
        "parent_id",
        "currency_id",
    ];

    public const TYPES = ['CONTINENT', 'COUNTRY', 'TOWN', 'DISTRICT'];

    public const COUNTRY = 'COUNTRY';

    public const TOWN = 'TOWN';

    /**
     * Full text search columns to take into account
     *
     * @var array
     */
     protected array $fullTextColumns = [ 'name' ];

    /**
     * A geo entity has a parent
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * A geo entity has chilren
     *
     * @return BelongsTo
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
