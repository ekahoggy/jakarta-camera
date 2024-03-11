<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    protected $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function addCart(Request $request) {
        $params = $request->all();

        dd($params);

        $model = $this->cart->addCart($params);
        
    }
}
