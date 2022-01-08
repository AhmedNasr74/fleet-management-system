<?php

namespace App\Services\Api;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseService
{
    public function send($data = null, $message = '', $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => $status >= 200 && $status < 300,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function sendMessage($message, $status): JsonResponse
    {
        return $this->send(null, $message, $status);
    }
}
