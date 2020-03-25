<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    Route::get('/', 'WebController@home')->name('home');

    /** Página de Venda - Específica de um produto */
    Route::get('/produto/{slug}', 'WebController@buyProduct')->name('buyProduct');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Rotas Protegidas */
    Route::group(['middleware' => ['auth']], function () {

        /** Dashboard Home */
        Route::get('home', 'AuthController@home')->name('home');

        /** Usuários */
        Route::resource('users', 'UserController');

        /** Permissões */
        Route::resource('permissions', 'ACL\\PermissionController');

        /** Perfis */
        Route::get('role/{role}/permissions', 'ACL\\RoleController@permissions')->name('role.permissions');
        Route::put('role/{role}/permission/sync', 'ACL\\RoleController@permissionsSync')->name('role.permissionsSync');
        Route::resource('role', 'ACL\\RoleController');

        /** Produtos */
        Route::post('products/image-set-cover', 'ProductController@imageSetCover')->name('products.imageSetCover');
        Route::delete('products/image-remove', 'ProductController@imageRemove')->name('products.imageRemove');
        Route::resource('products', 'ProductController');
    });

    /** Logout */
    Route::get('logout', 'AuthController@logout')->name('logout');

});