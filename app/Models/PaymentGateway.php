<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $table = 'm_payment_gateway';

    protected $fillable = [
        'name',
        'icon',
        'note',
        'created_at',
        'updated_at'
    ];

}
