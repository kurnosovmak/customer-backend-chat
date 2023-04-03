<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\BaseRequest;

final class LoginAuthRequest extends BaseRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
            'token_name' => 'required|string|max:255',
        ];
    }
}
