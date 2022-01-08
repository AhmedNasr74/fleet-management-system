<?php

namespace App\Traits;

use App\Services\Api\ApiResponseService;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestValidationErrorsResponse
{
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson())
            throw new HttpResponseException((new ApiResponseService())->send(['errors' => $validator->errors()], 'Validation Error', Response::HTTP_UNPROCESSABLE_ENTITY));
        else
            parent::failedValidation($validator);
    }
}
