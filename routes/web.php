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


Route::get('/get_token', function(){
   return response()->json(['_token'=>csrf_token()]);
});

Route::get('/firewall', 'ErrorNoticeController@firewall')->name('notice.firewall');

Route::get('/online_error','ErrorNoticeController@online')->name('notice.online_error');

Route::get('/online_time', 'ErrorNoticeController@onlineTime')->name('notice.onlinetime');

require base_path('routes/admin.php');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

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
Route::get('/room_robots/{id}', 'RoomController@robots')->name('room.robots');
Route::post('/room/robot_say', 'RoomController@robotSay')->name('room.robot_say');
Route::get('/room_today_message/{id}', 'RoomController@getTodayMessage')->name('room.todaymessage');
Route::get('/room_onlive', 'RoomController@onLiveRoom')->name('room.onlive');
Route::post('/room/live_code', 'RoomController@video')->name('room.video');



Route::get('/', 'MainController@index')->name('main.index');
Route::get('/roomlist', 'MainController@roomList')->name('main.roomlist');
Route::get('/m/login', 'MainController@login')->name('main.login');
Route::get('/m/register', 'MainController@register')->name('main.register');
Route::get('/livelist', 'MainController@livelist')->name('main.livelist');


Route::post('/update_user_profile', 'UserController@updateUserProfile')->name('user.updateprofile');
Route::post('/update_user_password', 'UserController@updatePassword')->name('user.updatepassword');
Route::get('/user_profile', 'UserController@index')->name('user.profile');
Route::get('/change_password', 'UserController@changePassword')->name('user.changepassword');


Route::get('/import_user/update_password', 'ImportUserController@updateUserPassword')->name('import.update_user_password');
Route::get('/import_user', 'ImportUserController@index')->name('import.index');
Route::get('/update_robot_rooms', 'ImportUserController@updateRobotRooms')->name('import.update_robot_rooms');



//Route::any('/wechat', 'WeChatController@serve');