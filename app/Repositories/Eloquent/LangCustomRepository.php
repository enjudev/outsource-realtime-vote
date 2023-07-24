<?php

namespace App\Repositories\Eloquent;

use App\Repositories\LangCustomRepositoryInterface;
use App\Models\Lang;

class LangCustomRepository extends RelationModelRepository implements LangCustomRepositoryInterface
{

    protected $querySearchTargets = [
    ];

    public function getBlankModel()
    {
        return new Lang();
    }
}
