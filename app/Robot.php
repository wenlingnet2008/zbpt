<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }

    public function rooms()
    {
        return $this->morphToMany(
            'App\Room',
            'model',
            'model_has_rooms',
            'model_id',
            'room_id'
        );
    }
}
