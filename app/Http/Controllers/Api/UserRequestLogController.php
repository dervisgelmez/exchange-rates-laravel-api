<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Models\UserRequestLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserRequestLogController extends ApiBaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $requestLogs = UserRequestLog::query();

        return $this->successResponse(
            $requestLogs->paginate($request->query->get('count', 15))->toArray()
        );

    }

    /**
     * @param int $userId
     * @param Request $request
     * @return JsonResponse
     */
    public function getLogsByUser(int $userId, Request $request): JsonResponse
    {
        $requestLogs = UserRequestLog::query()->where('user_id', '=', $userId);

        return $this->successResponse(
            $requestLogs->paginate($request->query->get('count', 15))->toArray()
        );
    }
}
