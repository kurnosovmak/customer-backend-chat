<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\TokenDTO;
use App\DTO\UserDTO;
use App\Models\User;

class TokenGenerateService
{
    public function __construct(protected User $user)
    {
    }

    public function generateFromUser(UserDTO $userDTO, array $scopes = []): TokenDTO
    {
        /** @var User $user */
        $user = $this->user->query()->findOrFail($userDTO->id);

        return TokenDTO::fromModel($user->createToken('auth', $scopes));
    }
}
