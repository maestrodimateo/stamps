<?php

namespace Modules\Admin\Models;

use Modules\Core\Traits\Model\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Model\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\GeoEntity;

/**
 * @author Noel Mebale <noel.mebale@aninf.ga>
 */
class Person extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = [
        'name', 'firstname', 'maiden_name', 'birthdate',
        'phone', 'gender', 'geo_entity_id', 'user_id'
    ];

    /**
     * Person genders
     */
    public const GENDERS = [ 'female' => 'F', 'male' => 'M' ];

    protected $casts = [ 'birthdate' => 'datetime' ];

    /**
     * Full text search columns to take into account
     *
     * @var array
     */
    protected array $fullTextColumns = [ 'name', 'firstname', 'maiden_name'];

    /**
     * Get the fullname
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        return $this->attributes['firstname'] ." ". $this->attributes['name'];
    }

    /**
     * Set the name uppercase
     *
     * @return void
     */
    public function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = strtoupper($name);
    }

    /**
     * Get set the firstname with the first letter uppercase
     *
     * @return void
     */
    public function setFirstnameAttribute(string $firstname): void
    {
        $this->attributes['firstname'] = ucfirst($firstname);
    }

    /**
     * A person can be a user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A person was born in a geographical entity
     *
     * @return BelongsTo
     */
    public function birthplace(): BelongsTo
    {
        return $this->belongsTo(GeoEntity::class, 'geo_entity_id');
    }
}
