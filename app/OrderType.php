<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
    public function order(){
       return $this->hasMany('App\Order', 'type_id');
    }
}
