<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 't_cart';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
    ];

    public function addCart($params) {
        $model = DB::table('t_cart')->insert($params);

        return $model;
    }
}
