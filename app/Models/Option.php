<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
       'title_ar','title_en', 'face', 'insta','whats' ,'phone' , 'active' , 'ios' , 'andriod','email','created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
