<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
