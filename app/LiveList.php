<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveList extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }
}
