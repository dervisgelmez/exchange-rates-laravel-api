<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Services\Core\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class AuthController extends ApiBaseController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(Auth::user()->toArray());
    }

    /**
     * @param Request $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function login(Request $request, AuthService $authService): JsonResponse
    {
        $request->validate([
            'username'    => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[0-9]/',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[*.!#$]/'
            ]
        ]);

        $response = $authService->loginWithRequest($request);

        return $this->successResponse($response);
    }
}
