<?php

namespace App\Identity\Exceptions;

use Exception;
use Illuminate\Http\Response;

class VkLoginException extends Exception
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
        //TODO Write normal text message
        return response()->json(['error' => 'error during login attempt'], 400);
    }
}
