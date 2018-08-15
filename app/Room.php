<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use GatewayClient\Gateway;

class Room extends Model
{
    use HasRoles;
    protected $guard_name = 'web';
    protected $fillable = ['name', 'content', 'logo', 'open', 'access_password',
        'pc_code', 'mobile_code', 'user_id', 'owner_id', 'time_limit', 'limit_groups', 'robot_open', 'say_limit'];
    public $timestamps = false;

    public function teacher()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    //代理商
    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }


    //加入房间
    public function join($user){
        if(self::userIsOnline($user['user_id'])){
            $this->closeUser($user['user_id']);
        }

        //绑定用户
        Gateway::bindUid($user['client_id'], $user['user_id']);
        //设置用户session Gateworker的服务器session
        $roles_user = User::find($user['user_id']);
        Gateway::setSession($user['client_id'], [
            'user_id' => $user['user_id'],
            'client_name'  => e($user['name']),
            'room_id' => $this->id,
            'roles' => $roles_user
                ? $roles_user->roles()->select('id', 'name')->get()->toArray()
                : [
                    ['id' => 5, 'name' => '游客'],
                  ],
        ]);
        //用户加入房间
        Gateway::joinGroup($user['client_id'], $this->id);
    }

    //获取房间所有在线用户
    public function getUserList()
    {
        $user_list = [];
        $clients = Gateway::getClientSessionsByGroup($this->id);
        foreach ($clients as $user){
            if(!empty($user['user_id'])){
                $user_list[$user['user_id']] = $user['client_name'] . '||' . $user['roles'][0]['name'];
            }
        }
        return $user_list;
    }

    //踢掉用户
    public function closeUser($user_id)
    {
        $client_ids = Gateway::getClientIdByUid($user_id);
        foreach ($client_ids as $client_id){
            Gateway::closeClient($client_id);
        }
    }

    //用户是否在线
    public static function userIsOnline($user_id)
    {
        return Gateway::isUidOnline($user_id);
    }

    //公聊
    public function sayAll(User $user, $content)
    {
        $content = nl2br(htmlspecialchars($content));
        $message = [
            'type'=>'say',
            'from_client_id'=>$user->id,
            'from_client_name' => e($user->nick_name ? $user->nick_name : $user->name),
            'to_client_id'=>'all',
            'content'=>$content,
            'roles' => $user->roles()->select('id', 'name')->get(),
            'time'=>date('Y-m-d H:i:s'),
        ];
        Gateway::sendToGroup($this->id ,json_encode($message));

        Message::create([
            'user_id' => $user->id,
            'user_name' => $user->nick_name ? $user->nick_name : $user->name,
            'to_user_id' => 0,
            'to_user_name' => 'All',
            'room_id' => $this->id,
            'content' => $content,
            'ip_address' => request()->ip(),
        ]);

    }

    //@用户 公聊
    public function sayToUser(User $user, User $to_user, $content)
    {
        $content = nl2br(htmlspecialchars($content));
        $message = [
            'type'=>'say',
            'from_client_id'=>$user->id,
            'from_client_name' => e($user->nick_name ? $user->nick_name : $user->name),
            'to_client_id'=>$to_user->id,
            'to_client_name'=> e($user->nick_name ? $user->nick_name : $user->name),
            'content'=>$content,
            'roles' => $user->roles()->select('id', 'name')->get(),
            'time'=>date('Y-m-d H:i:s'),
        ];

        Gateway::sendToGroup($this->id ,json_encode($message));

        Message::create([
            'user_id' => $user->id,
            'user_name' => $user->nick_name ? $user->nick_name : $user->name,
            'to_user_id' => $to_user->id,
            'to_user_name' => $user->nick_name ? $user->nick_name : $user->name,
            'room_id' => $this->id,
            'content' => $content,
            'ip_address' => request()->ip(),
        ]);
    }

    //私聊
    public function sayPrivate(User $user, User $to_user, $content)
    {
        $content = nl2br(htmlspecialchars($content));
        $message = [
            'type'=>'say_private',
            'from_client_id'=>$user->id,
            'from_client_name' => e($user->nick_name ? $user->nick_name : $user->name),
            'to_client_id'=>$to_user->id,
            'to_client_name'=> e($user->nick_name ? $user->nick_name : $user->name),
            'content'=>$content,
            'time'=>date('Y-m-d H:i:s'),
        ];

        Gateway::sendToUid($to_user->id, json_encode($message));
        Gateway::sendToUid($user->id, json_encode($message));


        Message::create([
            'user_id' => $user->id,
            'user_name' => $user->nick_name ? $user->nick_name : $user->name,
            'to_user_id' => $to_user->id,
            'to_user_name' => $user->nick_name ? $user->nick_name : $user->name,
            'room_id' => $this->id,
            'is_private' => 1,
            'content' => $content,
            'ip_address' => request()->ip(),
        ]);

    }



}
