<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';

    protected $fillable = [
        'currency_code',
        'cbr_code',
        'date',
        'nominal',
        'rate',
        'unit_rate'
    ];

    protected $visible = [
        'currency_code',
        'cbr_code',
        'date',
        'nominal',
        'rate',
        'unit_rate'
    ];

    public function historyItems()
    {
        return $this->hasMany(CurrencyHistoryItem::class, 'currency_id');
    }
}
