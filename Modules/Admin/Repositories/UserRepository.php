<?php
namespace Modules\Admin\Repositories;

use Illuminate\Support\Arr;
use Modules\Admin\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    protected string $model = User::class;

    /**
     * Create a user
     *
     * @param array $formData
     *
     * @return Model
     */
    public function create(array $formData): Model
    {
        return DB::transaction(function () use ($formData) {
            $user = User::create(Arr::except($formData, 'person'));
            $user->person()->create($formData['person']);
            return $user;
        });
    }

    /**
     * Update a user
     *
     * @param array $formData
     * @param Model $user
     *
     * @return bool
     */
    public function update(array $formData, Model $user): bool
    {
        return DB::transaction(function () use ($formData, $user) {
            $user->person()->update($formData['person']);
            return $user->update(Arr::except($formData, 'person'));
        });
    }

    /**
     * search a user
     *
     * @param string|null $search
     *
     * @return self
     */
    public function fullTextSearch(string $search = null): self
    {
        $this->builder
            ->search('email', $search)
            ->orWhereHas('person', function ($query) use ($search) {
            $query->fullTextSearch($search);
        });

        return $this;
    }
}
