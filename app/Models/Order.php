<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Notifiable;
    protected $hidden = [
        'created_at', 'updated_at','user_id','new'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
    public function pays()
    {
        return $this->hasMany('App\Models\Pay');
    }
    public function image()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'pay');
    }
}
