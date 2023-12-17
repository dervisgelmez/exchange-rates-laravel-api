<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Models\User;
use App\Services\Cache\RequestCacheService;
use App\Services\Core\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class UserController extends ApiBaseController
{
    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function register(Request $request, UserService $userService): JsonResponse
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users',
            'password'   => [
                'required',
                'string',
                'min:6',
                'regex:/[0-9]/',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[*.!#$]/'
            ]
        ]);

        $user = $userService->registerWithRequest($request);

        return $this->successResponse($user->toArray());
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function index(Request $request, UserService $userService): JsonResponse
    {
        if (RequestCacheService::hashCache($request)) {
            return $this->successResponse(
                RequestCacheService::getCache($request)
            );
        }

        $users = $userService->getUsers(new Request(['role' => User::USER_ROLE]));
        $response = $users->paginate($request->query->get('count', 15))->toArray();

        RequestCacheService::saveCache($request, $response);

        return $this->successResponse($response);
    }

    /**
     * @param int $userId
     * @param UserService $userService
     * @return JsonResponse
     */
    public function user(int $userId, UserService $userService): JsonResponse
    {
        $user = $userService->getUsers(
            new Request([
                'role' => User::USER_ROLE,
                'id' => $userId
            ])
        )->with(['requestLogs' => function ($query) {
            $query->limit(1);
            $query->orderBy('created_at', 'desc');
        }])->first();

        if (!$user) {
            throw new NotFoundHttpException('USER_NOT_FOUND');
        }

        return $this->successResponse($user->toArray());
    }
}
