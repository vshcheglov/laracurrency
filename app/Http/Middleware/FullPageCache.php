<?php

namespace App\Http\Middleware;

use App\Cache\Fpc\CacheKeyGeneratorInterface;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Container\Container;

class FullPageCache
{
    public function __construct(private int $ttl = 60 * 60 * 24)
    {
    }

    public function handle(
        $request,
        Closure $next,
        $ttl = null,
        $cacheKeyGeneratorClass = CacheKeyGeneratorInterface::class
    ) {
        $this->ttl = $ttl ?: $this->ttl;

        /** @var CacheKeyGeneratorInterface $keyGenerator */
        $keyGenerator = Container::getInstance()->make($cacheKeyGeneratorClass);
        $cacheKey = $keyGenerator->generateKey($request);

        $fpcStore = Cache::store('fpc');
        if ($fpcStore->has($cacheKey)) {
            return $fpcStore->get($cacheKey);
        }

        $response = $next($request);

        $fpcStore->put($cacheKey, $response, $this->ttl);

        return $response;
    }
}
