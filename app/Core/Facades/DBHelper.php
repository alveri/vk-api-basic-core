<?php

namespace App\Core\Facades;

use App\Core\Exceptions\DbTransactionFailException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;

class DBHelper extends Facade
{
    public static function transactionOrFail(\Closure $fn)
    {
        $result = DB::transaction($fn);

        if (!$result) {
            throw new DbTransactionFailException();
        }

        return $result;
    }
}
