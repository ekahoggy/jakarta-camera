<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MoodStudioProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static function createSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    public static function oneTreeView($table, $id){
        $data = DB::table($table)->selectRaw('*')->where('id', $id)->get();

        return $data;
    }

    public static function skuProduk(){
        $prefix = 'JC-';
        $data = DB::table('m_produk')->selectRaw('*')->count();

        return $prefix.$data + 1;
    }

    public static function kodePromo(){
        $prefix = 'PJC-';
        $data = DB::table('m_promo')->selectRaw('*')->count();

        return $prefix.$data + 1;
    }
}
