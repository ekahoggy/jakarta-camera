<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MServiceController;
use App\Http\Controllers\MResourceController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SiteController;

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
        Route::post('/add', [CartController::class, 'addCart'])->name('addcart');
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
