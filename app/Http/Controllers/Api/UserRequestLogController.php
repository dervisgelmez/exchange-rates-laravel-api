<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Models\UserRequestLog;
use App\Services\Cache\RequestCacheService;
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
        if (RequestCacheService::hashCache($request)) {
            return $this->successResponse(
                RequestCacheService::getCache($request)
            );
        }

        $requestLogs = UserRequestLog::query();
        $response = $requestLogs->paginate($request->query->get('count', 15))->toArray();

        RequestCacheService::saveCache($request, $response);

        return $this->successResponse($response);

    }

    /**
     * @param int $userId
     * @param Request $request
     * @return JsonResponse
     */
    public function getLogsByUser(int $userId, Request $request): JsonResponse
    {
        if (RequestCacheService::hashCache($request)) {
            return $this->successResponse(
                RequestCacheService::getCache($request)
            );
        }

        $requestLogs = UserRequestLog::query()->where('user_id', '=', $userId);
        $response = $requestLogs->paginate($request->query->get('count', 15))->toArray();

        RequestCacheService::saveCache($request, $response);

        return $this->successResponse($response);
    }
}
