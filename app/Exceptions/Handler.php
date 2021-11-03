<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $exception, $request) {
    
            if ($exception instanceof NotFoundHttpException) 
                return $this->customResponse(404, 'The specified URL cannot be found.');

            if ($exception instanceof MethodNotAllowedHttpException)
                return $this->customResponse(405, 'The specified method for the request is invalid');
    
            if ($exception instanceof HttpException)
                return $this->customResponse(401, $exception->getMessage());
            
            if ($exception instanceof ModelNotFoundException)
                return $this->customResponse(402, $exception->getMessage());

            if ($exception instanceof AuthenticationException)
                return $this->customResponse(401, ($exception->getMessage()) ? $exception->getMessage() : 'Unauthorized. ');
    
            if (config('app.debug'))
                return parent::render($request, $exception);
    
            return $this->customResponse(500, 'Unexpected Exception. Try later');
    
    
        });
    }

    private function customResponse($code, $message) {
        return response([
                'success' => false,
                'message' => $message
            ], $code);
    }
}
