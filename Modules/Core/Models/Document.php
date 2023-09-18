<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Model\HasUuid;
use Modules\Core\Traits\Model\WithSearch;

class Document extends Model
{
    use HasFactory, HasUuid, WithSearch;

    protected $fillable = [
        'path', 'mimetype',
        'size', 'documentable_type',
        'documentable_id'
    ];

    /**
     * Get the parent model.
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
