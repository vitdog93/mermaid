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
    'middleware' => ['auth', 'rbac:can,product.view'],
    'uses' => 'ProductController@index'
])->name('product');

Route::group([
    'prefix' => 'category',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,product.category.view'],
        'uses' => 'CategoryController@index'
    ])->name('product.category');
    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,product.category.view'],
        'uses' => 'CategoryController@detail'
    ]);
    Route::get('filter', [
        'middleware' => ['auth', 'rbac:can,product.category.view'],
        'uses' => 'CategoryController@filter'
    ]);
    Route::get('byParent/{id}', [
        'middleware' => ['auth', 'rbac:can,product.category.view'],
        'uses' => 'CategoryController@byParent'
    ]);
    Route::post('create', [
        'middleware' => ['auth', 'rbac:can,product.category.create'],
        'uses' => 'CategoryController@create'
    ]);
    Route::post('update/{id}', [
        'middleware' => ['auth', 'rbac:can,product.category.update'],
        'uses' => 'CategoryController@update'
    ]);
});
