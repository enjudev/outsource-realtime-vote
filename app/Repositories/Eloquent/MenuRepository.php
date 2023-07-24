<?php

namespace App\Repositories\Eloquent;

use App\Repositories\MenuRepositoryInterface;
use App\Models\Menu;

class MenuRepository extends RelationModelRepository implements MenuRepositoryInterface
{

    protected $querySearchTargets = [
        'name',
        'url',
        'status',
        
    ];

    public function getBlankModel()
    {
        return new Menu();
    }
}
