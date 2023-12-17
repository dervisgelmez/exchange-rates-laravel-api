<?php

namespace App\Services\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @param Request $request
     * @return Builder
     */
    public function getUsers(Request $request): Builder
    {
        $userBuilder = User::query();
        if ($role = $request->query->get('role')) {
            $userBuilder->where('role', '=', $role);
        }

        return $userBuilder;
    }
}
