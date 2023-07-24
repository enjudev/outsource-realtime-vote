<?php

namespace App\Repositories;

interface ConfigureRepositoryInterface extends RelationModelRepositoryInterface
{
    public function get_value($name);
    public function list_group();
    public function list($page);
    public function first_groupname($page);
}
