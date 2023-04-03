<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Auth\LoginAuthRequest;
use App\Services\Auth\CredentialAuthService;
use Illuminate\Http\JsonResponse;

final class AuthController extends BaseController
{
    public function __construct(protected CredentialAuthService $service)
    {
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
    }

    public function register(): JsonResponse
    {
    }

    public function logout(): JsonResponse
    {
    }

    public function confirmEmail(): JsonResponse
    {
    }
}
