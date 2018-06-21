<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'mobile', 'introduce', 'room_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function orders()
    {
        return $this->hasMany('App\Order', 'user_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }


    //获取所有讲师
    public static function getAllTeacher()
    {
        $teachers = self::whereHas('roles', function ($query) {
            $query->where('id', 6);
        })->get();

        return $teachers;
    }

    //获取所有代理商
    public static function getAllOwner()
    {
        $owners = self::whereHas('roles', function ($query) {
            $query->where('id', 7);
        })->get();

        return $owners;
    }

    public function isAdmin()
    {
        $admin = Role::findById(1);
        if ($this->hasRole($admin) and $this->is_admin === 1) {
            return true;
        }
        return false;
    }

    public function isTeacher()
    {
        $teacher = Role::findById(6);
        if ($this->hasRole($teacher)) {
            return true;
        }
        return false;
    }

    //是否是代理商
    public function isOwner()
    {
        $owner = Role::findById(7);
        if($this->hasRole($owner)){
            return true;
        }
        return false;
    }

    public function isMute()
    {
        return $this->forbid_talk;
    }

    //禁止发言
    public function mute()
    {
        $this->forbid_talk = 1;
        $this->save();
    }

    //解除禁言
    public function unmute()
    {
        $this->forbid_talk = 0;
        $this->save();
    }
}
