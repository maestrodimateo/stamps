<?php
namespace Modules\Stamp\Repositories;

use \Modules\Stamp\Models\Stamp;
use Modules\Core\Repositories\AbstractRepository;

class StampRepository extends AbstractRepository
{
    protected string $model = Stamp::class;
}
