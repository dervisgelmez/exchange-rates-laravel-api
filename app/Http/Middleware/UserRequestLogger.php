<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserRequestLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRequestLogger
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();
        if ($user && $user->role != User::ADMIN_ROLE) {
            UserRequestLog::query()->create([
                'user_id' => Auth::user()->id,
                'endpoint' => $request->getRequestUri()
            ]);
        }
        return $next($request);
    }
}
