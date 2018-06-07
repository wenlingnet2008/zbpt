<?php

Route::get('admin/login', 'Admin\LoginController@login')->name('admin.login');
Route::post('admin/check-login', 'Admin\LoginController@checkLogin')->name('admin.checklogin');


Route::prefix('admin')->middleware('auth.admin')->namespace('Admin')->name('admin.')->group(function (){
    Route::get('dashboard', 'DashboardController@index')->name('dash.index');
    Route::get('main', 'DashboardController@main')->name('dash.main');
    Route::get('password', 'DashboardController@password')->name('dash.password');
    Route::post('change_password', 'DashboardController@changePassword')->name('dash.changepassword');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('left', function(){ return view('admin.left');})->name('left');

    Route::get('siteconfig', 'SiteconfigController@index')->name('siteconfig');
    Route::post('siteconfig/update', 'SiteconfigController@update')->name('siteconfig.update');


    Route::resource('roles', 'RoleController');

    Route::resource('permissions', 'PermissionController');

    Route::resource('orders', 'OrderController');
    Route::resource('ordertypes', 'OrderTypeController');

    Route::resource('users', 'UserController');

    Route::get('/firewall', 'FirewallController@index')->name('firewall.index');
    Route::post('/firewall', 'FirewallController@store')->name('firewall.store');
    Route::delete('/firewall', 'FirewallController@delete')->name('firewall.delete');

    Route::resource('rooms', 'RoomController');
});