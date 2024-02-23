<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MServiceController;
use App\Http\Controllers\MResourceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KegiatanDraftController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WidgetController;
use App\Models\Donations;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::get('/detail-event/{id}', [DashboardController::class, 'getDetailHistoryEvent'])->middleware('auth');
    Route::get('/statistic', [DashboardController::class, 'getStatic']); //->middleware('auth');

    Route::prefix('user')->group(function (){
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::prefix('role')->group(function (){
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::prefix('kategori')->group(function (){
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/store', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::post('/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    Route::prefix('produk')->group(function (){
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/store', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::post('/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        Route::get('/getAllProduk', [ProdukController::class, 'getProduk']);
        Route::get('/getProdukById/{id?}', [ProdukController::class, 'getProdukById']);
    });

    Route::prefix('promo')->group(function (){
        Route::get('/', [PromoController::class, 'index'])->name('promo.index');
        Route::get('/create', [PromoController::class, 'create'])->name('promo.create');
        Route::post('/store', [PromoController::class, 'store'])->name('promo.store');
        Route::get('/edit/{id}', [PromoController::class, 'edit'])->name('promo.edit');
        Route::post('/update/{id}', [PromoController::class, 'update'])->name('promo.update');
        Route::delete('/delete/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');
    });

    Route::prefix('voucher')->group(function (){
        Route::get('/', [VoucherController::class, 'index'])->name('voucher.index');
        Route::get('/create', [VoucherController::class, 'create'])->name('voucher.create');
        Route::post('/store', [VoucherController::class, 'store'])->name('voucher.store');
        Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
        Route::post('/update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::delete('/delete/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
    });

    Route::prefix('testimoni')->group(function (){
        Route::get('/', [TestimoniController::class, 'index'])->name('testimoni.index');
        Route::get('/create', [TestimoniController::class, 'create'])->name('testimoni.create');
        Route::post('/store', [TestimoniController::class, 'store'])->name('testimoni.store');
        Route::get('/edit/{id}', [TestimoniController::class, 'edit'])->name('testimoni.edit');
        Route::post('/update/{id}', [TestimoniController::class, 'update'])->name('testimoni.update');
        Route::post('/updateStatus/{id}', [TestimoniController::class, 'updateStatus']);
        Route::delete('/delete/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
    });

    Route::prefix('page')->group(function (){
        Route::get('/', [PageController::class, 'index'])->name('page.index');
        Route::get('/create', [PageController::class, 'create'])->name('page.create');
        Route::post('/store', [PageController::class, 'store'])->name('page.store');
        Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
        Route::post('/update/{id}', [PageController::class, 'update'])->name('page.update');
        Route::post('/updateStatus/{id}', [PageController::class, 'updateStatus']);
        Route::post('/duplicate/{id}', [PageController::class, 'duplicate']);
        Route::delete('/delete/{id}', [PageController::class, 'destroy'])->name('page.destroy');
        Route::delete('/deleteDetail/{id}', [PageController::class, 'destroyDetail']);
    });
    Route::prefix('donasi')->group(function (){
        Route::get('/', [DonationController::class, 'index'])->name('donasi.index');
        Route::get('/one-time-donation', [DonationController::class, 'index'])->name('donasi.index');
        Route::get('/sponsorship-anak', [DonationController::class, 'index'])->name('donasi.index');
        Route::get('/create', [DonationController::class, 'create'])->name('donasi.create');
        Route::post('/store', [DonationController::class, 'store'])->name('donasi.store');
        Route::get('/edit/{id}', [DonationController::class, 'edit'])->name('donasi.edit');
        Route::post('/update/{id}', [DonationController::class, 'update'])->name('donasi.update');
        Route::post('/updateIDN/{id}', [DonationController::class, 'updateIDN'])->name('donasi.updateIDN');
        Route::delete('/delete/{id}', [DonationController::class, 'destroy'])->name('donasi.destroy');
        Route::get('/export',[DonationController::class, 'export'])->name('export');
        Route::get('/updateAll',[DonationController::class, 'updateAll'])->name('updateAll');
    });
    Route::prefix('kegiatan')->group(function (){
        Route::get('/', [KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/edit/{id}', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::post('/update/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::post('/updateStatus/{id}', [KegiatanController::class, 'updateStatus']);
        Route::delete('/delete/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
    });
    Route::prefix('kegiatandraft')->group(function (){
        Route::get('/', [KegiatanDraftController::class, 'index'])->name('kegiatandraft.index');
        Route::get('/create', [KegiatanDraftController::class, 'create'])->name('kegiatandraft.create');
        Route::post('/store', [KegiatanDraftController::class, 'store'])->name('kegiatandraft.store');
        Route::get('/edit/{id}', [KegiatanDraftController::class, 'edit'])->name('kegiatandraft.edit');
        Route::post('/update/{id}', [KegiatanDraftController::class, 'update'])->name('kegiatandraft.update');
        Route::delete('/delete/{id}', [KegiatanDraftController::class, 'destroy'])->name('kegiatandraft.destroy');
    });
    Route::prefix('slider')->group(function (){
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });
    Route::prefix('media')->group(function (){
        Route::get('/', [MediaController::class, 'index'])->name('media.index');
        Route::get('/create', [MediaController::class, 'create'])->name('media.create');
        Route::post('/store', [MediaController::class, 'store'])->name('media.store');
        Route::get('/edit/{id}', [MediaController::class, 'edit'])->name('media.edit');
        Route::post('/update/{id}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('/delete/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
        Route::delete('/deleteAll/{ids}', [MediaController::class, 'destroyAll'])->name('media.destroyAll');
    });

    Route::get('/resource', [MResourceController::class, 'index'])->name('resource.index');
    Route::get('/resource/create', [MResourceController::class, 'create'])->name('resource.create');
    Route::post('/resource/store', [MResourceController::class, 'store'])->name('resource.store');
    Route::get('/resource/edit/{id}', [MResourceController::class, 'edit'])->name('resource.edit');
    Route::post('/resource/update/{id}', [MResourceController::class, 'update'])->name('resource.update');
    Route::delete('/resource/delete/{id}', [MResourceController::class, 'destroy'])->name('resource.destroy');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/subscription/edit/{id}', [SubscriptionController::class, 'edit'])->name('subscription.edit');
    Route::post('/subscription/update/{id}', [SubscriptionController::class, 'update'])->name('subscription.update');
    Route::delete('/subscription/delete/{id}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');


    Route::prefix('seo')->group(function (){
        Route::get('/', [SettingController::class, 'getSEO'])->name('seo.index');
        Route::post('/save', [SettingController::class, 'saveSEO'])->name('seo.save');
    });
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/view/{id}', [SettingController::class, 'view'])->name('setting.view');
    Route::post('/setting/updateStatus/{id}', [SettingController::class, 'updateStatus']);

    Route::get('/widget-donation', [WidgetController::class, 'index'])->name('widget-donation.index');
    Route::get('/widget-donation/create', [WidgetController::class, 'create'])->name('widget-donation.create');
    Route::post('/widget-donation/store', [WidgetController::class, 'store'])->name('widget-donation.store');
    Route::get('/widget-donation/edit/{id}', [WidgetController::class, 'edit'])->name('widget-donation.edit');
    Route::post('/widget-donation/update/{id}', [WidgetController::class, 'update'])->name('widget-donation.update');
    Route::delete('/widget-donation/delete/{id}', [WidgetController::class, 'destroy'])->name('widget-donation.destroy');
    Route::post('/widget-donation/updateStatus/{id}', [WidgetController::class, 'updateStatus']);

    // widget detail
    Route::get('/widget-donation-detail/{id}', [WidgetController::class, 'getDetailWidget']);
    Route::post('/widget-donation-detail/store', [WidgetController::class, 'storeDetailWidget']);
    Route::post('/widget-donation-detail/update/{id}', [WidgetController::class, 'updateDetailWidget']);
    Route::delete('/widget-donation-detail/delete/{id}', [WidgetController::class, 'deleteDetailWidget']);

    // get img & upload img
    Route::get('/get-item-img', [MediaController::class, 'getImg']);
    Route::post('/save-item-img', [MediaController::class, 'saveImg']);

    // update index slide (drag n drop)
    Route::post('/update-position/{id}', [SliderController::class, 'updateIndex']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

Route::get('/sendVerification', [LoginController::class, 'sendVerification'])->name('sendVerification');

Route::prefix('api')->group(function (){
    Route::prefix('v1')->group(function (){
        Route::prefix('public')->group(function (){
            Route::get('/kategori', [SiteController::class, 'kategori'])->name('kategori');
            Route::get('/produk', [SiteController::class, 'produk'])->name('produk');
            Route::get('/slider', [SiteController::class, 'slider'])->name('slider');
            Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
            Route::get('/page', [SiteController::class, 'page'])->name('page');
            Route::get('/event', [SiteController::class, 'event'])->name('event');
            Route::get('/galeri', [SiteController::class, 'galeri'])->name('galeri');
            Route::get('/testimoni', [SiteController::class, 'testimoni'])->name('testimoni');
            Route::get('/widgetPageDonasi', [SiteController::class, 'widgetPageDonasi'])->name('widgetPageDonasi');

            Route::get('/country', [SiteController::class, 'country'])->name('country');
            Route::get('/city', [SiteController::class, 'city'])->name('city');
            Route::get('/place', [SiteController::class, 'place'])->name('place');
            Route::get('/widget', [SiteController::class, 'widget'])->name('widget');
            Route::get('/widgetSetting', [SiteController::class, 'settingWidget'])->name('settingWidget');

            Route::post('/subscription', [SiteController::class, 'subscription']);
            Route::post('/donation', [SiteController::class, 'donation']);
            Route::post('/updateDonation', [SiteController::class, 'updateDonation']);
            Route::post('/midtrans-callback', [SiteController::class, 'midtransCallback']);
            Route::post('/notification-url', [SiteController::class, 'notificationURL']);

            Route::get('/payment', [SiteController::class, 'payment'])->name('payment');
            Route::get('/paymentDetail', [SiteController::class, 'paymentDetail'])->name('paymentDetail');

            Route::get('/cronjob', [SiteController::class, 'cronjob'])->name('cronjob');
        });
    });
});
