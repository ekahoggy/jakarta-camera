<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'm_promo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'redeem_code',
        'voucher',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'gambar',
        'deskripsi',
        'kategori',
        'qty',
        'voucher_user',
        'type',
        'voucher_value',
        'voucher_max',
        'voucher_min_beli',
        'is_status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
