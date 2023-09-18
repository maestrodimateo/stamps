<?php
namespace Modules\Stamp\Repositories;

use \Modules\Stamp\Models\Type;
use Modules\Core\Repositories\AbstractRepository;

class TypeRepository extends AbstractRepository
{
    protected string $model = Type::class;
}
