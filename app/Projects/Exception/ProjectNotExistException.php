<?php

namespace App\Projects\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ProjectNotExistException extends Exception
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
        return response()->json(['errors' => 'project with this id doesnt exist'], 400);
    }
}
