<?php

namespace App\Core\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Projects\Exceptions\PermissionsException;
use App\Core\Exceptions\VkApiException;
use App\Core\Exceptions\NotJsonBodyException;
use App\Projects\Exceptions\ProjectNotExistException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \App\Projects\Exceptions\PermissionsException::class,
        \App\Projects\Exceptions\VkApiException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof PermissionsException) {
            return $exception->render($request);
        }
        if ($exception instanceof VkApiException) {
            return $exception->render($request);
        }
        if ($exception instanceof NotJsonBodyException) {
            return $exception->render($request);
        }
        if ($exception instanceof ProjectNotExistException) {
            return $exception->render($request);
        }
        return parent::render($request, $exception);
    }
}
