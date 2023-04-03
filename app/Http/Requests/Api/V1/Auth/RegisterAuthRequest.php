<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\BaseRequest;
use Illuminate\Contracts\Validation\Rule;

final class RegisterAuthRequest extends BaseRequest
{
    /**
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }
}
