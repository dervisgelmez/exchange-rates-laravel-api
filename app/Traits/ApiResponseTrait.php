<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * @param array $data
     * @param mixed|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse(
        array $data,
        ?string $message = null,
        int $code = 200
    ): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * @param int $code
     * @param mixed|null $message
     * @return JsonResponse
     */
    protected function errorResponse(
        int $code,
        string $message
    ): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'data'    => null
        ], $code);
    }
}
