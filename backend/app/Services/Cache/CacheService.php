<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function setCache(string $key, string $value, int $expire): bool
    {
        return Cache::set($key, $value, $expire);
    }

    public function getCache(string $key): mixed
    {
        return Cache::get($key);
    }
}
