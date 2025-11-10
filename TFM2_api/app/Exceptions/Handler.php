<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // You can add reportable/renderable callbacks here if needed
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        $isApi = $request->expectsJson() || $request->is('api/*');

        if ($isApi) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Route not found',
                ], 404);
            }
        }

        return parent::render($request, $e);
    }
}

