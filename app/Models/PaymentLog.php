<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $table = 'payment_logs';

    protected $fillable = [
        'madison_quary_id',
        'ayasman_card_id',
        'amount',
        'payment_id',
        'created_at',
        'updated_at'
    ];
}
