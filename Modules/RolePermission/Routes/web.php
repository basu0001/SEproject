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

Route::prefix('rolepermission')->group(function() {
    Route::get('/', 'RolePermissionController@index');
    Route::get('/about', 'RolePermissionController@about');
    Route::get('role', 'RolePermissionController@role');
    Route::post('role-store', 'RolePermissionController@roleStore');
    Route::get('role-edit/{id}', 'RolePermissionController@roleEdit');
    Route::post('role-update', 'RolePermissionController@roleUpdate');
    Route::post('role-delete', 'RolePermissionController@roleDelete');

    //  permission module


    Route::get('assign-permission/{id}', 'RolePermissionController@assignPermission');
    Route::post('role-permission-assign', 'RolePermissionController@rolePermissionAssign');


    Route::get('about', 'RolePermissionController@about');

});
