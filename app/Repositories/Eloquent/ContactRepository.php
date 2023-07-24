<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ContactRepositoryInterface;
use App\Models\Contact;

class ContactRepository extends RelationModelRepository implements ContactRepositoryInterface
{

    protected $querySearchTargets = [

    ];

    public function getBlankModel()
    {
        return new Contact();
    }
}
