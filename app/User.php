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
        'name', 'email', 'password', 'image', 'mobile', 'introduce'
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

    public function isAdmin()
    {
        $admin = Role::findById(1);
        if($this->hasRole($admin) and $this->is_admin === 1){
            return true;
        }
        return false;
    }

    public function isTeacher()
    {
        $teacher = Role::findById(6);
        if($this->hasRole($teacher)){
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
