<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }
    protected $fillable = [
        'name_ar', 'name_en','body_ar', 'body_en','image', 'images','video' , 'category_id','subcategory_id' ,'price' ,'discount_price' , 'body_ar' ,'body_en','active',
        'created_at','updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at','subcategory_id','category_id'
    ];

    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'Active' : 'Unactive';
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id' , 'id');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Models\Category' , 'subcategory_id' , 'id');
    }

    public function mainImage()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'main');
    }
    public function subImages()
    {
        return $this->morphMany('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'sub');
    }
    public function video()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'video');
    }
    public function file()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'file');
    }
    public function wishes()
    {
        return $this->hasMany('App\Models\WishList');
    }
}
