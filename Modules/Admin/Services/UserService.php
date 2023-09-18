<?php
namespace Modules\Admin\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Admin\Models\User;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Services\AbstractService;
use Modules\Admin\Emails\DefaultPasswordSent;
use Modules\Admin\Models\Role;
use Modules\Admin\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(UserRepository $userRepository, Request $request)
    {
        parent::__construct($userRepository, $request);
    }

    /**
     * Create a new user and assign permissions
     *
     *
     * @return User
     */
    public function create(): User
    {
        $userCreated = $this->repository->create($this->request->all());

        Mail::to($userCreated)->send(new DefaultPasswordSent($this->request->password, $userCreated->person->fullname));

        return $userCreated;
    }

    /**
     * Get the resources
     *
     * @return Collection|LengthAwarePaginator
     */
    public function get(): Collection|LengthAwarePaginator
    {
        $this->repository->builder
        ->whereRelation('role','label', '<>', Role::ROLES['super'])
        ->withTrashed();
        return parent::get();
    }
}
