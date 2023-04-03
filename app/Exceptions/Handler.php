<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Throwable;

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
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return new JsonResponse([
                'status' => false,
                ...json_decode(Router::toResponse($request, $response)->getContent(), true),
            ], status: Router::toResponse($request, $response)->getStatusCode());
        }

        if ($e instanceof Responsable) {
            return new JsonResponse([
                'status' => false,
                ...json_decode($e->toResponse($request)->getContent(), true),
            ], status: $e->toResponse($request)->getStatusCode());
        }

        $e = $this->prepareException($this->mapException($e));

        if ($response = $this->renderViaCallbacks($request, $e)) {
            return new JsonResponse([
                'status' => false,
                ...json_decode($response->getContent(), true),
            ], status: $response->getStatusCode());
        }

        $response = match (true) {
            $e instanceof HttpResponseException => $e->getResponse(),
            $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            default => $this->exceptionNotFund($e),
        };
        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return new JsonResponse([
            'status' => false,
            ...(json_decode($response->getContent(), true) ?? []),
        ], status: $response->getStatusCode());
    }

    private function exceptionNotFund(Throwable $e): JsonResponse
    {
        logger()->error($e->getMessage(), [
            'error'=>$e,
        ]);

        return new JsonResponse([
            'message' => $e->getMessage(),
        ], status: 500);
    }
}
