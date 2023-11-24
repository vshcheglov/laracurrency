<?php

namespace App\Cache\Fpc;

use Illuminate\Http\Request;

class CurrencyCacheKeyGenerator implements CacheKeyGeneratorInterface
{
    public function generateKey(Request $request): string
    {
        $joinedKeyParts = implode('_', [
            $request->path(),
            $request->input('fromDate'),
            $request->input('toDate')
        ]);
        return 'fpc_' . md5($joinedKeyParts);
    }
}
