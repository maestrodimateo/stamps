<?php
namespace Modules\Admin\Models;

use Laravel\Sanctum\HasApiTokens;
use Modules\Core\Traits\Model\HasUuid;
use Modules\Core\Traits\Model\WithSearch;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Stamp\Models\StampProjectRelationsTrait;

/**
 * @author Noel Mebale <noel.mebale@aninf.ga>
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory, Notifiable,
        HasUuid, WithSearch,
        SoftDeletes, StampProjectRelationsTrait;

    protected $fillable = [
        'email',
        'avatar',
        'username',
        'password',
        'role_id',
        'password_changed',
        'last_login',
    ];

    protected array $fullTextColumns = [ 'email', 'username' ];

    /**
     * Fields to be hidden
     *
     * @var array
     */
    protected $hidden = [ 'password' ];

    protected $casts = [ 'last_login' => 'datetime' ];

    /**
     * A user can be a person
     *
     * @return HasOne
     */
    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    /**
     * Hash and set the password
     *
     * @param string $password : Unhashed password
     *
     * @return void
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * A user has only one role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * check if the use has a specific role
     *
     * @param string $roleName
     *
     * @return bool
     */
    public function roleIs(string $roleName): bool
    {
        return $this->role->label === strtolower($roleName);
    }
}
