<?php

namespace App\Http\Requests\User\Auth;

use App\Traits\RequestValidationErrorsResponse;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use RequestValidationErrorsResponse;

    public function rules(): array
    {
        return [
            'email' => ['required' , 'email'],
            'password' => ['required' , 'string'],
        ];
    }
}
