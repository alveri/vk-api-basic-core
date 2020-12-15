<?php

namespace App\Tokens\Exceptions;

use Exception;
use Illuminate\Http\Response;

class VkApiException extends Exception
{
    public $message;

    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request): Response
    {
        return response()->json(['errors' => $this->message], 400);
    }
}
