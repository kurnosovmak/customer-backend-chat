<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\Auth\TokenDTO;
use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

final class CredentialAuthService
{
    public function __construct(protected User $user)
    {
    }

    /**
     * @param LoginDTO $loginDTO
     * @param array<int, string> $scopes
     * @return TokenDTO
     */
    public function login(LoginDTO $loginDTO, array $scopes = []): UserDTO
    {
        /** @var User $user */
        $user = $this->user->query()->where('email', $loginDTO->email)->first();
        if (! $user || ! Hash::check($loginDTO->password, $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return UserDTO::fromModel($user);
    }

    public function register(RegisterDTO $registerDTO): UserDTO
    {
        $user = $this->user->query()->where('email', $registerDTO->email)->first();
        if ($user) {
            throw new AuthenticationException('User with email - '.$registerDTO->email.'exists.');
        }
        /** @var User $user */
        $user = $this->user->query()->create([
            ...$registerDTO->toArray(),
            'password' => Hash::make($registerDTO->password),
        ]);

        return UserDTO::fromModel($user);
    }
}
