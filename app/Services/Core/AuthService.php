<?php

namespace App\Services\Core;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class AuthService
{
    public function loginWithRequest(Request $request): array
    {
        $user = User::where('username', $request->request->get('username'))->first();
        if (!$user) {
            throw new NotFoundHttpException('NOT_FOUND_USER_WITH_USERNAME');
        }
        if (!Hash::check($request->request->get('password'), $user->password)) {
            throw new UnprocessableEntityHttpException('WRONG_PASSWORD');
        }

        $token = $user->createToken('apiConnect');

        return [
            'user' => $user->toArray(),
            'accessToken' => $token->plainTextToken
        ];
    }
}
