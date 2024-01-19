<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;

    protected $table = 't_donations';

    protected $fillable = [
        'no_donation',
        'm_events_id',
        'type',
        'qty',
        'nominal',
        'total_donation',
        'name',
        'email',
        'phone_code',
        'phone_number',
        'address',
        'gender',
        'wnsm',
        'idn_anak',
        "bank",
        "card_type",
        "finish_redirect_url",
        "masked_card",
        "payment_type",
        "transaction_id",
        "transaction_time",
        'transaction_status',
    ];
}
