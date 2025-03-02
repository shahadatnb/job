<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class CustomHelperFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'customerHelper';
    }
}
