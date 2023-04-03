<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use Laravel\Passport\PersonalAccessTokenResult;
use Spatie\LaravelData\Data;

final class TokenDTO extends Data
{
    public function __construct(
        public string $accessToken,
    ) {
    }

    public static function fromModel(PersonalAccessTokenResult $accessTokenResult): self
    {
        return new self(
            accessToken: $accessTokenResult->accessToken
        );
    }
}
