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

Route::get('/is_login', 'RoomController@isLogin')->name('room.islogin');

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
Route::get('/room_teacher/{id}', 'RoomController@teacher')->name('room.teacher');
Route::get('/room_orders/{id}', 'RoomController@orders')->name('room.orders');
Route::get('/room_user/{user_id}', 'RoomController@user')->name('room.user');
Route::post('/room/permission_menu', 'RoomController@getDoPermissionMenu')->name('room.getdopermissionmenu');
Route::post('/room/private_user_list', 'RoomController@privateUserList')->name('room.privateuserlist');
Route::post('/room/private_say_list', 'RoomController@privateSayList')->name('room.privatesaylist');
Route::post('/room/search_online_user', 'RoomController@searchOnlineUser')->name('room.searchonlineuser');
Route::get('/room_customer_service/{id}', 'RoomController@customerService')->name('room.customerservice');

//Route::any('/wechat', 'WeChatController@serve');