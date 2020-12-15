<?php

namespace App\CallbackServer\Exceptions;

use Exception;
use lluminate\Http\Response;

class CallbackServerNotExistException extends Exception
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
        return response()->json(['errors' => 'This callbackServer doesnt exists'], 400);
    }
}
