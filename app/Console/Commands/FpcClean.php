<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FpcClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fpc:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean full page cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::store('fpc')->clear();
    }
}
