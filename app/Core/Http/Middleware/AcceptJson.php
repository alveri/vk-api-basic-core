<?php

namespace App\Core\Http\Middleware;

use Closure;
use App\Core\Exceptions\NotJsonBodyException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class AcceptJson
{
    public function handle($request, Closure $next): Response
    {
        $body = json_decode($request->getContent());
        if( json_last_error()!==JSON_ERROR_NONE ) {
            throw new NotJsonBodyException();
        }

        return $next($request);
    }
}
