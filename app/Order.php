<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasRoles;
    protected $guard_name = 'web';

    protected $fillable = ['type_id', 'doing', 'open_price', 'stop_price', 'earn_price', 'position', 'user_id', 'room_id'];

    public function order_type(){
        return $this->belongsTo('App\OrderType', 'type_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }
}
