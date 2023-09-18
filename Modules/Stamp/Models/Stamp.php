<?php

namespace Modules\Stamp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\Models\User;
use Modules\Core\Traits\Model\HasUuid;
use Modules\Core\Traits\Model\WithSearch;
use Modules\Stamp\Services\StampService;

class Stamp extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = [
        'reference', 'qrcode',
        'type_id', 'user_id'
    ];

    /**
     * full text search attributes
     *
     * @var array<string>
     */
    protected $fullTextColumns = [];

    /**
     * Actions to be done during creation
     *
     * @param Model $stamp
     *
     * @return void
     */
    protected static function creatingActions(Model $stamp)
    {
        $stamp->reference = generateCode();
    }

    /**
     * A stamp has a type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * A stamp can be created by only one person
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
