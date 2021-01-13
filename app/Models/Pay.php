<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use Notifiable;
    protected $hidden = [
        'created_at', 'updated_at','order_id','product_id'
    ];
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

}
