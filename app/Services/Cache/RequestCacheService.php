<?php

namespace App\Services\Cache;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class RequestCacheService
{
    private static function generateKey(Request $request): string
    {
        return md5("resp_{$request->fullUrl()}");
    }

    public static function hashCache(Request $request): bool
    {
        return Cache::store()->has(self::generateKey($request));
    }

    public static function getCache(Request $request): array
    {
        return json_decode(Cache::store('redis')->get(self::generateKey($request)), true);
    }

    public static function saveCache(Request $request, array $data): void
    {
        Cache::store('redis')->put(self::generateKey($request), json_encode($data, true), now()->addMinutes(5));
    }
}
