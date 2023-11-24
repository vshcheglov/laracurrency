<?php

namespace App\Console\Commands;

use App\Services\CurrencyUpdate\CurrencyUpdateInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CurrencyUpdate extends Command
{
    public function __construct(private readonly CurrencyUpdateInterface $currencyUpdate)
    {
        parent::__construct();
    }

    protected $signature = 'app:currency:update';
    protected $description = 'Updates currencies from external source';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->currencyUpdate->execute();
        Cache::store('currency')->clear();
        Cache::store('fpc')->clear();
    }
}
