<?php
namespace Modules\Core\Services;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\AbstractRepository;
use Modules\Core\Traits\Services\HandleFile;

abstract class AbstractService
{
    use HandleFile;

    /**
     * Constructor
     *
     * @param AbstractRepository $userRepository
     */
    public function __construct(protected AbstractRepository $repository, protected Request $request)
    {}

    /**
     * Business logic to create a resource
     *
     * @return Model
     */
    public function create(): Model
    {
        return $this->repository->create($this->request->all());
    }

    /**
     * Perform a multiple criteria research
     *
     * @param array $relations
     * @param Closure $callback
     *
     * @return self
     */
    public function fullTextSearch(array $relations = [], Closure $callback = null): self
    {
        if ($this->request->has('search') && $this->request->filled('search')) {
            $this->repository->fullTextSearch($this->request->query('search'))->with($relations, $callback);
        }

        $this->repository->with($relations, $callback);

        return $this;
    }

    /**
     * Perform a simple research
     *
     * @return self
     */
    public function search(string $attribute, array $relations = [], Closure $callback = null): self
    {
        $this->repository->search($attribute, $this->request->query('search'))
        ->with($relations, $callback);

        return $this;
    }

    /**
     * Add pagination to the request if it exists
     */
    public function get(): Collection|LengthAwarePaginator
    {
        $this->filter();

        return ($this->request->has('paginate')) ?
        $this->repository->builder->paginate($this->request->query('paginate', 10))
        ->appends($this->request->except('page')) :
        $this->repository->builder->get();
    }

    /**
     * Business logic to update a resource
     *
     * @param Model $model
     *
     * @return bool
     */
    public function update(Model $model): bool
    {
       return $this->repository->update($this->request->all(), $model);
    }

    /**
     * Business logic to delete a resource
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function delete(Model $model): bool|null
    {
        return $this->repository->delete($model);
    }

    /**
     * Business logic to destroy a resource
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public function destroy(Model $model): bool|null
    {
        return $this->repository->destroy($model);
    }

    /**
     * Restore the resource when it has been soft deleted
     *
     * @return bool|null
     */
    public function restore(Model $model): bool|null
    {
        return $this->repository->restore($model);
    }

    /**
     * Add filters
     *
     * @return void
     */
    protected function filter()
    {
        $this->repository->builder
        ->orderBy('created_at', $this->request->query('order', 'desc'));
    }
}
