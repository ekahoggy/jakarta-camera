<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayDetail extends Model
{
    use HasFactory;
    protected $table = 'm_payment_gateway_det';

    protected $fillable = [
        'name',
        'payment_gateway_id',
        'icon',
        'url',
        'is_status',
        'created_at',
        'updated_at'
    ];
}
