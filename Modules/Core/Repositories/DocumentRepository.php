<?php
namespace Modules\Core\Repositories;

use \Modules\Core\Models\Document;
use Modules\Core\Repositories\AbstractRepository;

class DocumentRepository extends AbstractRepository
{
    protected string $model = Document::class;
}
