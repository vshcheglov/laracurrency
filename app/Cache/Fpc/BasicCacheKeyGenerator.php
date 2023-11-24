<?php

namespace App\Cache\Fpc;

use Illuminate\Http\Request;

class BasicCacheKeyGenerator implements CacheKeyGeneratorInterface
{
    public function generateKey(Request $request): string
    {
        return 'fpc_' . md5($request->url());
    }
}
