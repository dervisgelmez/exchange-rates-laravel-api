<?php

namespace App\Services\Core;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    /**
     * @param Request $request
     * @return User
     */
    public function registerWithRequest(Request $request): User
    {
        return User::create([
            'first_name' => $request->request->get('firstName'),
            'last_name'  => $request->request->get('lastName'),
            'username'   => $request->request->get('username'),
            'role'       => User::USER_ROLE,
            'password'   => Hash::make($request->request->get('password'))
        ]);
    }
}
