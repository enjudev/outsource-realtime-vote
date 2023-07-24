<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Kreait\Firebase\Factory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $firebase;
    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount(storage_path('key.json'))->withDatabaseUri(env('FIREBASE_DATABASE_URL'))->createDatabase();
    }
}
