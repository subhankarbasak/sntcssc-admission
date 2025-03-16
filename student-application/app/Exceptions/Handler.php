<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation errors.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle API requests
        if ($request->expectsJson()) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['error' => 'Resource not found'], 404);
            }

            return response()->json(['error' => 'Something went wrong'], 500);
        }

        // Handle web requests
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            dd($statusCode);

            // Prepare error details (only in local environment)
            $errorDetails = [];
            if (app()->environment('local')) {
                $errorDetails = [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ];
            }

            // Check if a custom error view exists for the status code
            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [
                    'exception' => $exception,
                    'errorDetails' => $errorDetails,
                ], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }
}