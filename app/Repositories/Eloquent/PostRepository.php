<?php

namespace App\Repositories\Eloquent;

use App\Repositories\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends RelationModelRepository implements PostRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new Post();
    }
}
