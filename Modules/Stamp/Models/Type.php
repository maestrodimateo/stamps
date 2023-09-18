<?php

namespace Modules\Stamp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Traits\Model\HasUuid;
use Modules\Core\Traits\Model\WithSearch;

class Type extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = [ 'label', 'price' ];

    protected $casts = [ 'price' => 'int' ];

    /**
     * A type has many stamps
     *
     * @return HasMany
     */
    public function stamps(): HasMany
    {
        return $this->hasMany(Stamp::class);
    }
}
