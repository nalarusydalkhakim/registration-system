<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedException) {
            return response()->json([
                'code' => '403',
                'message' => 'You do not have permission to perform this action.',
                'error' => 'Forbidden',
            ], 403);
        }

        if ($e instanceof CustomException) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'code' => '401',
                'message' => 'Authentication is required to access this resource.',
                'error' => 'Unauthorized',
            ], 401);
        }
        if ($request->wantsJson()) {
            return $this->prepareJsonResponse($request, $e);
        }
        return parent::render($request, $e);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        $code = 500;
        $message = "";
        $errors = [];
        try {
            $message = $e->getMessage() ?? '';
            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                $code = 404;
                $message = 'Data tidak ditemukan';
            } else if ($e instanceof UnauthorizedException) {
                $code = 403;
                $message = 'Anda tidak diizinkan mengakses halaman ini';
            } else if ($e instanceof AccessDeniedHttpException) {
                $code = 403;
                $message = $e->getMessage() ?? 'Anda tidak diizinkan mengakses halaman ini';
            } else if ($e instanceof ValidationException) {
                $code = 422;
                $message = $e->getMessage() ?? 'Data tidak valid';
                $errors = $e->errors();
            }
        } catch (\Throwable $th) {
        }
        return response()->json([
            'success'   => false,
            'code'      => $code,
            'message'   => $message,
            'errors'    => $errors
        ], $code);
    }
}
