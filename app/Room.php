<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Room extends Model
{
    use HasRoles;
    protected $guard_name = 'web';
    protected $fillable = ['name', 'content', 'logo', 'open', 'access_password', 'pc_code', 'mobile_code', 'user_id'];
    public $timestamps = false;

    public function teacher()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
