<?php

namespace App\Cache\Fpc;

use Illuminate\Http\Request;

interface CacheKeyGeneratorInterface
{
    public function generateKey(Request $request): string;
}
