<?php

namespace App\Repositories\Eloquent;

use App\Repositories\PostCommentRepositoryInterface;
use App\Models\PostComment;

class PostCommentRepository extends RelationModelRepository implements PostCommentRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new PostComment();
    }
}
