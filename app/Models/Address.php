<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'fullname', 'street_address','building_no', 'active' , 'city_id' ,'user_id' ,'area' , 'phone','created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at' , 'city_id' , 'user_id',
    ];
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'Selected' : '';
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
