<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Http\Requests\Api\V1\Auth\LoginAuthRequest;
use App\Http\Requests\Api\V1\Auth\RegisterAuthRequest;
use App\Services\Auth\CredentialAuthService;
use App\Services\Auth\TokenGenerateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class AuthController extends BaseController
{
    public function __construct(
        protected CredentialAuthService $credentialAuthService,
        protected TokenGenerateService $tokenGenerateService
    ) {
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
        $user = $this->credentialAuthService->login(
            LoginDTO::fromArray($request->only(['email', 'password', 'token_name']))
        );

        return $this->success(
            data: $this->tokenGenerateService->generateFromUser($user)->toArray(),
        );
    }

    public function register(RegisterAuthRequest $request): JsonResponse
    {
        $this->credentialAuthService->register(
            RegisterDTO::fromArray($request->only(['email', 'password', 'name']))
        );

        return $this->success(status: Response::HTTP_ACCEPTED);
    }

    public function logout(): JsonResponse
    {
    }

    public function confirmEmail(): JsonResponse
    {
    }
}
