<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdatePersonalAccessToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $personalAccessToken;
    protected $newAttributes;

    public function __construct($personalAccessToken, $newAttributes)
    {
        $this->personalAccessToken = $personalAccessToken;
        $this->newAttributes = $newAttributes;
    }

    public function handle()
    {
        DB::table('personal_access_tokens')
            ->where('id', $this->personalAccessToken->id)
            ->update($this->newAttributes);
    }
}
