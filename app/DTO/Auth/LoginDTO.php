<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use Spatie\LaravelData\Data;

final class LoginDTO extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public string $tokenName,
    ) {
    }

    /**
     * @param array<string, string> $array
     * @return static
     */
    public static function fromArray(array $array): self
    {
        return new self(
            email: $array['email'],
            password: $array['password'],
            tokenName: $array['token_name'],
        );
    }
}
