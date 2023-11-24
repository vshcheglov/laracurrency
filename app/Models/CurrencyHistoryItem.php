<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyHistoryItem extends Model
{
    protected $table = 'currency_history';

    protected $fillable = [
        'currency_id',
        'date',
        'nominal',
        'rate',
        'unit_rate'
    ];

    protected $visible = [
        'date',
        'rate',
        'unit_rate'
    ];

}
