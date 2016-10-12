<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Ajax extends Facade
{

    public static $data;
    public static $errors;

    protected static function getFacadeAccessor()
    {
        return 'App\Http\Controllers\AjaxController';
    }
}