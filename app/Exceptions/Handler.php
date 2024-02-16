<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
            if ($e instanceof Exception) {
                Log::channel('custom-log')->error($e->getMessage());
            } else { 
                parent::report($e);
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
            return response()->view('error.404', [], 404);
        }
        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return response()->view('error.403', [], 403);
        }
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            return response()->view('error.500', [], 500);
        }
        if ($exception instanceof HttpException && $exception->getStatusCode() == 503) {
            return response()->view('error.503', [], 500);
        }

        return parent::render($request, $exception);
    }
}
