<?php
namespace App\Classes\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class HelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Helper';
    }
}