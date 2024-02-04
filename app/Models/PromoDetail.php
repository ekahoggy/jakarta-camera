<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoDetail extends Model
{
    use HasFactory;

    protected $table = 'm_promo_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'm_promo_id',
        'm_produk_id',
        'diskon_persen',
        'diskon_nominal',
        'promo_used',
        'qty'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
