<?php
namespace Modules\Core\Traits\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->getKey()) {
                self::creatingActions($model);
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });

        static::created(fn ($model) => self::createdActions($model));
    }

    /**
     * Remove the ability to increment
     *
     * @return void
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * The type of the id
     *
     * @return void
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * More actions in the creation part
     *
     * @param Model $model
     * @return void
     */
    protected static function creatingActions(Model $model)
    {
        //Todo
    }

    /**
     * More actions in the created part
     *
     * @param Model $model
     * @return void
     */
    protected static function createdActions(Model $model)
    {
        //Todo
    }
}
