<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MServiceController;
use App\Http\Controllers\MResourceController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Artisan;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

Route::get('/get-all-service', [MServiceController::class, 'getAllService']);
Route::get('/get-all-resources', [MResourceController::class, 'getAllResource']);
Route::post('/send-email', [MailController::class, 'sendEmail']);
Route::get('/download-pdf', [MServiceController::class, 'downloadPdf']);

Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('optimize');

    return response(['Berhasil melakukan optimasi cache']);
});

Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');

    return response(['Berhasil melakukan manipulasi storage']);
});
