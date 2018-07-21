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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/get_token', function(){
   return response()->json(['_token'=>csrf_token()]);
});

Route::get('/firewall', 'ErrorNoticeController@firewall')->name('notice.firewall');

Route::get('/online_error','ErrorNoticeController@online')->name('notice.online_error');

Route::get('/online_time', 'ErrorNoticeController@onlineTime')->name('notice.onlinetime');

require base_path('routes/admin.php');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/room/{id}', 'RoomController@index')->name('room.index');
Route::post('/room/login', 'RoomController@login')->name('room.login');
Route::post('/room/say', 'RoomController@say')->name('room.say');
Route::post('/room/sayprivate', 'RoomController@sayPrivate')->name('room.sayprivate');
Route::post('/room/flush', 'RoomController@flush')->name('room.flush');
Route::get('/room_check_online', 'RoomController@checkClientOnline')->name('room.checkonline');
Route::post('/room/kick', 'RoomController@kick')->name('room.kick');
Route::post('/room/mute', 'RoomController@mute')->name('room.mute');
Route::post('/room/unmute', 'RoomController@unmute')->name('room.unmute');
Route::get('/room_access/{id}', 'RoomController@access')->name('room.access');


//Route::any('/wechat', 'WeChatController@serve');