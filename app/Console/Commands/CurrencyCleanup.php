<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CurrencyHistoryItem;
use Carbon\Carbon;

class CurrencyCleanup extends Command
{
    protected $signature = 'app:currency:cleanup';
    protected $description = 'Delete currency history records older than 3 months';

    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $count = CurrencyHistoryItem::where('date', '<', $threeMonthsAgo)->delete();

        $this->info("Deleted $count old currency history records.");
    }
}
