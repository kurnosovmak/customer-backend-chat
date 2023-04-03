<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\User;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class UserDTO extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?Carbon $emailVerifiedAt,
        public string $password,
    ) {
    }

    /**
     * @param array<string, string> $array
     * @return static
     */
    public static function fromArray(array $array): self
    {
        return new self(
            id: (int) $array['id'],
            name: $array['name'],
            email: $array['email'],
            emailVerifiedAt: ($array['email_verified_at'] ?? null) !== null
                ? Carbon::make($array['email_verified_at'])
                : null,
            password: $array['password'],
        );
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: (int) $user->getAttribute('id'),
            name: $user->getAttribute('name'),
            email: $user->getAttribute('email'),
            emailVerifiedAt: $user->getAttribute('email_verified_at') !== null
                ? Carbon::make($user->getAttribute('email_verified_at'))
                : null,
            password: $user->getAttribute('password'),
        );
    }
}
