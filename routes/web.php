<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\CobaMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormSurveyController;
use App\Http\Controllers\JobHistoryController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
// Route::group(['middleware' => ['auth']], function () {
Route::group(["middleware" => ['auth', 'checkuserrole:pelanggan']], function () {
    Route::controller(BerandaController::class)->group(function() {
        Route::get('/', 'index')->name('beranda');
    });
    Route::controller(KeranjangController::class)->group(function() {
        Route::get('/keranjang/{param}', 'index')->name('keranjang.index');
        Route::put('/keranjang/addToCart/{param}', 'addToCart')->name('keranjang.addToCart');
        Route::put('/keranjang/updateQuantityCart/{param}', 'updateQuantityCart')->name('keranjang.updateQuantityCart');
        Route::delete('/keranjang/removeProductCart/{param}', 'removeProductCart')->name('keranjang.removeProductCart');
        Route::post('/keranjang/checkout', 'checkout')->name('keranjang.checkout');
    });
    Route::controller(OrderController::class)->group(function() {
        Route::get('/order', 'index')->name('order.index');
        Route::get('/order/detailCheckout/{param}', 'detailCheckout')->name('order.detailCheckout');
    });
});

Route::group(["middleware" => ['auth', 'checkuserrole:superadmin,pegawai']], function () {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });

    Route::controller(UserController::class)->group(function() {
        Route::get('/user', 'index')->name('user.index')->middleware('checkmenupermission');
        Route::get('/user/datatable', 'datatable')->name('user.datatable');
        Route::get('/user/modal/create', 'create')->name('user.modal.create');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/modal/edit/{param}', 'edit')->name('user.modal.edit');
        Route::put('/user/update/{param}', 'update')->name('user.update');
        Route::delete('/user/{param}', 'delete')->name('user.delete');
    });

    Route::controller(ProdukController::class)->group(function() {
        Route::get('/produk', 'index')->name('produk.index')->middleware('checkmenupermission');
        Route::get('/produk/datatable', 'datatable')->name('produk.datatable');
        Route::get('/produk/modal/create', 'create')->name('produk.modal.create');
        Route::post('/produk/store', 'store')->name('produk.store');
        Route::get('/produk/modal/edit/{param}', 'edit')->name('produk.modal.edit');
        Route::put('/produk/update/{param}', 'update')->name('produk.update');
        Route::delete('/produk/{param}', 'delete')->name('produk.delete');
    });
    Route::controller(RoleController::class)->group(function() {
        Route::get('/role', 'index')->name('role.index')->middleware('checkmenupermission');
        Route::get('/role/datatable', 'datatable')->name('role.datatable');
        Route::get('/role/modal/create', 'create')->name('role.modal.create');
        Route::post('/role/store', 'store')->name('role.store');
        Route::get('/role/modal/edit/{param}', 'edit')->name('role.modal.edit');
        Route::put('/role/update/{param}', 'update')->name('role.update');
        Route::delete('/role/{param}', 'delete')->name('role.delete');
    });
    Route::controller(JobHistoryController::class)->group(function() {
        Route::get('/job-user', 'index')->name('jobuser.index')->middleware('checkmenupermission');
        Route::get('/job-user/datatable', 'datatable')->name('jobuser.datatable');
        Route::get('/job-user/modal/show/{param}', 'show')->name('jobuser.modal.show');
        Route::get('/job-user/modal/edit/{param}', 'edit')->name('jobuser.modal.edit');
        Route::put('/job-user/update/{param}', 'update')->name('jobuser.update');
    });
    Route::controller(MenuController::class)->group(function() {
        Route::get('/menu', 'index')->name('menu.index')->middleware('checkmenupermission');
        Route::get('/menu/datatable', 'datatable')->name('menu.datatable');
        Route::get('/menu/modal/create', 'create')->name('menu.modal.create');
        Route::post('/menu/store', 'store')->name('menu.store');
        Route::get('/menu/modal/edit/{param}', 'edit')->name('menu.modal.edit');
        Route::put('/menu/update/{param}', 'update')->name('menu.update');
        Route::delete('/menu/{param}', 'delete')->name('menu.delete');
    });
    Route::controller(SubMenuController::class)->group(function() {
        Route::get('/sub-menu/{param}', 'index')->name('submenu.index');
        Route::get('/sub-menu/datatable/{param}', 'datatable')->name('submenu.datatable');
        Route::get('/sub-menu/modal/create/{param}', 'create')->name('submenu.modal.create');
        Route::post('/sub-menu/store/{param}', 'store')->name('submenu.store');
        Route::get('/sub-menu/modal/edit/{param}', 'edit')->name('submenu.modal.edit');
        Route::put('/sub-menu/update/{param}', 'update')->name('submenu.update');
        Route::delete('/sub-menu/{param}', 'delete')->name('submenu.delete');
    });
    Route::controller(PermissionController::class)->group(function() {
        Route::get('/permission', 'index')->name('permission.index')->middleware('checkmenupermission');
        Route::get('/permission/datatable', 'datatable')->name('permission.datatable');
        Route::get('/permission/edit/{param}', 'edit')->name('permission.edit');
        Route::put('/permission/update/{param}', 'update')->name('permission.update');
    });
    Route::controller(CobaMenuController::class)->group(function() {
        Route::get('/coba-menu', 'index')->name('cobamenu.index');
        Route::get('/cobam-enu/datatable', 'datatable')->name('cobamenu.datatable');
        Route::get('/coba-menu/modal/create', 'create')->name('cobamenu.modal.create');
        Route::post('/coba-menu/store', 'store')->name('cobamenu.store');
        Route::get('/coba-menu/modal/edit/{param}', 'edit')->name('cobamenu.modal.edit');
        Route::put('/coba-menu/update/{param}', 'update')->name('cobamenu.update');
        Route::delete('/coba-menu/{param}', 'delete')->name('cobamenu.delete');
    });
});
