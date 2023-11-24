<?php

namespace App\Models;

use App\Jobs\UpdatePersonalAccessToken;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Support\Facades\Cache;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    public static function findToken($token)
    {
        return Cache::remember("PersonalAccessToken::$token", 600, function () use ($token) {
            return parent::findToken($token) ?? '_null_';
        });
    }

    public function getTokenableAttribute()
    {
        return Cache::remember("PersonalAccessToken::{$this->id}::tokenable", 600, function () {
            return parent::tokenable()->first();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function (self $personalAccessToken) {
            try {
                Cache::remember("PersonalAccessToken::lastUsageUpdate", 3600, function () use ($personalAccessToken) {
                    dispatch(new UpdatePersonalAccessToken($personalAccessToken, $personalAccessToken->getDirty()));
                    return now();
                });
            } catch (\Throwable $e) {
                Log::critical($e->getMessage());
            }
            return false;
        });
    }
}
