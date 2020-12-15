<?php

namespace App\CallbackServer\Exceptions;

use Exception;
use lluminate\Http\Response;

class CallbackServerException extends Exception
{

    public array $errorResponse;

    public function __construct(array $errorResponse)
    {
        parent::__construct();
        $this->$errorResponse = $errorResponse;
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request): Response
    {
        // TODO ??? $ in variables
        return response()->json(['errors' => [
                'code' => $this->$errorResponse['error']['error_code'],
                'error' => $this->$errorResponse['error']['error_msg'],
            ]
        ], 400);
    }
}
