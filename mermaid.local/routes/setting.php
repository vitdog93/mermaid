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
    'middleware' => ['auth', 'rbac:can,setting.view'],
    'uses' => 'SettingController@index'
])->name('setting');

Route::group([
    'prefix' => 'user',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,setting.user.view'],
        'uses' => 'UserController@index'
    ])->name('setting.user');

    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.user.view'],
        'uses' => 'UserController@detail'
    ]);

    Route::post('create', [
        'middleware' => ['auth', 'rbac:can,setting.user.create'],
        'uses' => 'UserController@create'
    ]);

    Route::post('update/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.user.update'],
        'uses' => 'UserController@update'
    ]);
});

Route::group([
    'prefix' => 'role',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,setting.role.view'],
        'uses' => 'RoleController@index'
    ])->name('setting.role');
    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.role.view'],
        'uses' => 'RoleController@detail'
    ]);
    Route::post('create', [
        'middleware' => ['auth', 'rbac:can,setting.role.create'],
        'uses' => 'RoleController@create'
    ]);
    Route::post('update/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.role.update'],
        'uses' => 'RoleController@update'
    ]);
    Route::get('permission/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.role.view'],
        'uses' => 'RoleController@permission'
    ]);
    Route::post('permission/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.role.update'],
        'uses' => 'RoleController@syncPermission'
    ]);
});

Route::group([
    'prefix' => 'permission',
], function () {
    Route::get('', [
        'middleware' => ['auth', 'rbac:can,setting.permission.view'],
        'uses' => 'PermissionController@index'
    ])->name('setting.permission');
    Route::get('detail/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.permission.view'],
        'uses' => 'PermissionController@detail'
    ]);
    Route::post('create', [
        'middleware' => ['auth', 'rbac:can,setting.permission.create'],
        'uses' => 'PermissionController@create'
    ]);
    Route::post('update/{id}', [
        'middleware' => ['auth', 'rbac:can,setting.permission.update'],
        'uses' => 'PermissionController@update'
    ]);
});
