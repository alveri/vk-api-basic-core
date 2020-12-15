<?php

namespace App\Core\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AuthException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request): Response
    {
        return response()->json(['errors' => 'unauthorized request'], 401);
    }
}
