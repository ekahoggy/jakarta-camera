<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as Generator;

class Address extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'users_address';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'recipient',
        'phone_code',
        'phone_number',
        'village_id',
        'subdistrict_id',
        'city_id',
        'province_id',
        'postal_code',
        'address',
        'is_active',
    ];

    public function getAddress($params) {
        $data = DB::table('users_address')
            ->select(
                'users_address.*', 
                'village.desa as village_name', 
                'subdistrict.kecamatan as subdistrict_name',
                'city.kota as city_name',
                'province.provinsi as province_name'
            )
            ->leftJoin('village', 'village.id', '=', 'users_address.village_id')
            ->leftJoin('subdistrict', 'subdistrict.id', '=', 'users_address.subdistrict_id')
            ->leftJoin('city', 'city.id', '=', 'users_address.city_id')
            ->leftJoin('province', 'province.id', '=', 'users_address.province_id')
            ->get();

        return $data;
    }

    public function checkAddress($params) {
        $payload = [];
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('users_address')
            ->select('quantity')
            ->where($payload)
            ->first();
    }

    public function insertAddress($params) {
        $params['id'] = Generator::uuid4()->toString();
        return DB::table('users_address')->insert($params);
    }

    public function updateAddress($params) {
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('users_address')->where($payload)->update($params);
    }

    public function changeAddress($params) {
        $payload['user_id'] = $params['user_id'];
        $payload['product_id'] = $params['product_id'];

        return DB::table('users_address')->where($payload)->update(['quantity' => $params['quantity']]);
    }

    public function deleteAddress($params) {
        return DB::table('users_address')->where(['id' => $params['id']])->delete();
    }
}
