<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'm_promo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'kode',
        'promo',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'promo_min_beli',
        'is_flashsale',
        'is_status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
