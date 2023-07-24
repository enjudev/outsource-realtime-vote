<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ConfigureRepositoryInterface;
use App\Models\Configure;

class ConfigureRepository extends RelationModelRepository implements ConfigureRepositoryInterface
{

    protected $querySearchTargets = [
    ];

    public function getBlankModel()
    {
        return new Configure();
    }
    public function get_value($name)
    {
        $model = $this->getBlankModel()->orderBy('id', 'DESC')->where('configure_name', $name)->first();

        return $model;
    }
    public function list_group()
    {
        $model = $this->getBlankModel()->select('group_ordering')->distinct()->orderBy('group_ordering', 'ASC')->get();
        return $model;
    }
    public function first_groupname($page)
    {
//        dd($page)
        $model = $this->getBlankModel()->where('group_ordering',$page)->select('group_name')->first();

        return $model;
    }
    public function list($page)
    {
        $model = $this->getBlankModel()->orderBy('configure_ordering', 'ASC')->where('configure_publish', 1)->where('group_ordering', $page)->get();
        return $model;
    }
}
