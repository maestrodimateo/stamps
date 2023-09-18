<?php
namespace Modules\Core\Repositories;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractRepository
{
    /**
     * The model to be used for queries
     *
     * @var Model
     */
    protected string $model;

    /**
     * To generate queries
     *
     * @var Builder
     */
    public Builder $builder;

    public function __construct()
    {
        $this->builder = $this->model::query();
    }

    /**
     * Create a new resource
     *
     * @param array $formData
     *
     * @return Model
     */
    public function create(array $formData): Model
    {
        return $this->model::create($formData);
    }

    /**
     * Update the model
     *
     * @param array $formData
     * @param Model $model
     *
     * @return bool
     */
    public function update(array $formData, Model $model): bool
    {
        return $model->update($formData);
    }

    /**
     * Delete a model
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function delete(Model $model): bool|null
    {
        return $model->delete();
    }

    /**
     * search a resource on multiple columns
     *
     * @param string|null $search
     *
     * @return self
     */
    public function fullTextSearch(string $search = null): self
    {
        $this->builder->fullTextSearch($search);

        return $this;
    }

   /**
     * Search a resource on one column
     *
     * @param string|null $search
     *
     * @return self
     */
    public function search(string $attribute, string $search = null): self
    {
        $this->builder->search($attribute, $search);

        return $this;
    }

    /**
     * Add relations to the query result
     *
     * @param array $relations
     *
     * @return self
     */
    public function with(array $relations, Closure $callback = null): self
    {
        $this->builder->with($relations, $callback);
        return $this;
    }

    /**
     * Restore the resource when it has been soft deleted
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function restore(Model $model): bool|null
    {
        return $model->restore();
    }

    /**
     * Find the specified model
     *
     * @param mixed $id
     *
     * @return Model|null
     */
    public function find(mixed $id)
    {
        return $this->builder->find($id);
    }

    /**
     * Find the first colleciton value
     *
     * @return Model|null
     */
    public function first()
    {
        return $this->builder->first();
    }

    /**
     * Destroy a resource
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function destroy(Model $model): bool|null
    {
        return $model->forceDelete();
    }

}
