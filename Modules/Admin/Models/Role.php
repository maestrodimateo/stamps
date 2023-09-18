<?php

namespace Modules\Admin\Models;

use Modules\Core\Traits\Model\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Model\WithSearch;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @author Noel Mebale <noel.mebale@aninf.ga>
 */
class Role extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = ['label', 'description'];

    /**
     * Predefined roles
     */
    public const ROLES = [
        'super' => 'Superadmin',
        'admin' => 'Admin',
    ];

    /**
     * A role can have many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * A role can be assigned to multiple users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get a role according to its key
     *
     * @param string $key : key used in the ROLE constant
     *
     * @return self
     */
    public static function getOne(string $key): self
    {
        return self::where('label', self::ROLES[$key])->first();
    }
}
