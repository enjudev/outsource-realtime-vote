<?php

namespace App\Repositories\Eloquent;

use App\Repositories\SeoRepositoryInterface;
use App\Models\Seo;

class SeoRepository extends RelationModelRepository implements SeoRepositoryInterface
{

    protected $querySearchTargets = [
        //
    ];

    public function getBlankModel()
    {
        return new Seo();
    }
}
