<?php

namespace App\Repository\Facades;
use \Illuminate\Support\Facades\Facade;
class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repository\Services\UserService';
    }
}