<?php

use Illuminate\Support\Facades\Route;

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
Route::get('', [
    'middleware' => ['auth', 'rbac:can,account.view'],
    'uses' => 'AccountController@index'
])->name('account');

Route::group([
    'prefix' => 'buyer',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,account.buyer.view'],
        'uses' => 'BuyerController@index'
    ])->name('account.buyer');
    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,account.buyer.view'],
        'uses' => 'BuyerController@detail'
    ])->name('account.buyer.detail');
});

Route::group([
    'prefix' => 'seller',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,account.seller.view'],
        'uses' => 'SellerController@index'
    ])->name('account.seller');
    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,account.seller.view'],
        'uses' => 'SellerController@detail'
    ])->name('account.seller.detail');
});

Route::group([
    'prefix' => 'topup',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,account.topup.view'],
        'uses' => 'TopupController@index'
    ])->name('account.topup');
});
