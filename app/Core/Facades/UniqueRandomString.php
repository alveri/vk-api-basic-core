<?php

namespace App\Core\Facades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class UniqueRandomString extends Facade
{
    public static function uniqueRandom(string $table,string $col, $chars = 16): string
    {
       $unique = false;

       $tested = [];

       do{

           //$random = str_random($chars);
           $random = Str::random($chars);

           if( in_array($random, $tested) ){
               continue;
           }

           $count = DB::table($table)->where($col, '=', $random)->count();

           $tested[] = $random;

           if( $count == 0){
               $unique = true;
           }

       }
       while(!$unique);

       return $random;
    }
}
