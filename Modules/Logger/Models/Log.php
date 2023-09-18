<?php

namespace Modules\Logger\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Model\HasUuid;

class Log extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'ip', 'author_id', 'action',
        'description', 'user_agent',
        'author_fullname'
    ];

    /**
     * Get info logs
     *
     * @param Builder $query
     * @param string $description
     * @param string $action
     * @return void
     */
    public function scopeInfo(Builder $query, string $description, string $action): void
    {
        if (!auth()->user()) {
            return;
        }
        $query->create([
            'ip' => request()->ip(),
            'author_id' => auth()->user()->id,
            'action' => $action,
            'description' => $description,
            'user_agent' => request()->userAgent(),
            'author_fullname' => auth()->user()->person->fullname,
        ]);
    }
}
