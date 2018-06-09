<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/firewall', function(){
   return view('admin.error_notice', ['permission'=>'禁止访问']);
});

require_once base_path('routes/admin.php');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/room/{id}', 'RoomController@index')->name('room.index');
Route::post('/room/login', 'RoomController@login')->name('room.login');
Route::post('/room/say', 'RoomController@say')->name('room.say');
Route::post('/room/flush', 'RoomController@flush')->name('room.flush');
