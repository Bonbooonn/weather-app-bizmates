<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Places extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'places';
    }
}
