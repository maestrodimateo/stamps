<?php
namespace Modules\Stamp\Services;

use Illuminate\Http\Request;
use Modules\Core\Services\AbstractService;
use \Modules\Stamp\Repositories\TypeRepository;

class TypeService extends AbstractService
{
    public function __construct(TypeRepository $typeRepository, Request $request)
    {
        parent::__construct($typeRepository, $request);
    }
}
