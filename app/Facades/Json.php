<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/9/24
 * Time: 上午2:04
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Json extends Facade{
    protected static function getFacadeAccessor(){
        return 'json';
    }
}
