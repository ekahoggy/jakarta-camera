<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MServiceController;
use App\Http\Controllers\MResourceController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\RegionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){
    // Public
    Route::prefix('public')->group(function (){
        // user post
        Route::post('/checkEmail', [UserController::class, 'checkEmail']);
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);

        // public
        Route::get('/kategori', [KategoriController::class, 'kategori'])->name('kategori');
        Route::get('/produk', [ProdukController::class, 'produk'])->name('produk');
        Route::get('/getProdukSlug', [ProdukController::class, 'getProdukSlug'])->name('getProdukSlug');
        Route::get('/katalog', [ProdukController::class, 'katalog'])->name('katalog');
        Route::get('/slider', [SiteController::class, 'slider'])->name('slider');
    });

    // Cart
    Route::prefix('cart')->group(function (){
        Route::get('/get', [CartController::class, 'getCart'])->name('getCart');
        Route::post('/add', [CartController::class, 'addCart'])->name('addCart');
        Route::post('/update', [CartController::class, 'updateCart'])->name('updateCart');
        Route::post('/delete', [CartController::class, 'deleteCart'])->name('deleteCart');
    });

    // Cart
    Route::prefix('address')->group(function (){
        Route::get('/get', [AddressController::class, 'getAddress'])->name('getAddress');
        Route::post('/add', [AddressController::class, 'addAddress'])->name('addAddress');
        Route::post('/update', [AddressController::class, 'updateAddress'])->name('updateAddress');
        Route::post('/delete', [AddressController::class, 'deleteAddress'])->name('deleteAddress');
    });

    // Region
    Route::prefix('region')->group(function (){
        Route::get('/village', [RegionController::class, 'village'])->name('village');
        Route::get('/subdistrict', [RegionController::class, 'subdistrict'])->name('subdistrict');
        Route::get('/city', [RegionController::class, 'city'])->name('city');
        Route::get('/province', [RegionController::class, 'province'])->name('province');
    });

    Route::get('/make-password', function() {
        $password = bcrypt('123456');
    
        return response([
            'message' => 'Berhasil melakukan manipulasi storage',
            'password' => $password
        ]);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-all-service', [MServiceController::class, 'getAllService']);
Route::get('/get-all-resources', [MResourceController::class, 'getAllResource']);
Route::post('/send-email', [MailController::class, 'sendEmail']);
Route::get('/download-pdf', [MServiceController::class, 'downloadPdf']);
Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');

    return response(['Berhasil melakukan manipulasi storage']);
});
