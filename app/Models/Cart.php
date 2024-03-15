<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as Generator;

class Cart extends Model
{
    use HasFactory;
    public $timestamps = true;
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

    public function getCart($params) {
        $data = DB::table('t_cart')
            ->select(
                't_cart.id', 
                't_cart.product_id', 
                't_cart.user_id', 
                't_cart.quantity',
                'm_produk.nama',
                'm_produk.harga'
            )
            ->leftJoin('m_produk', 'm_produk.id', '=', 't_cart.product_id')
            ->where($params)
            ->get();

        return $data;
    }

    public function checkCart($params) {
        $payload = [];
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('t_cart')
            ->select('quantity')
            ->where($payload)
            ->first();
    }

    public function insertCart($params) {
        $params['id'] = Generator::uuid4()->toString();
        return DB::table('t_cart')->insert($params);
    }

    public function updateCart($params) {
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('t_cart')->where($payload)->update($params);
    }

    public function changeCart($params) {
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('t_cart')->where($payload)->update(['quantity' => $params['quantity']]);
    }

    public function deleteCart($params) {
        return DB::table('t_cart')->where(['id' => $params['id']])->delete();
    }
}
