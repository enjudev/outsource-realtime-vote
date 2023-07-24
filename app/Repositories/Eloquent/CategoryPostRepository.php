<?php

namespace App\Repositories\Eloquent;

use App\Repositories\CategoryPostRepositoryInterface;
use App\Models\CategoryPost;

class CategoryPostRepository extends RelationModelRepository implements CategoryPostRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new CategoryPost();
    }
}
