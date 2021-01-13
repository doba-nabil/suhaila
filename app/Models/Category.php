<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
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
        'name_ar', 'name_en','body_ar', 'body_en','image', 'active' , 'parent_id' ,'created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function scopeHome($query)
    {
        return $query->where('home_page' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'Active' : 'Unactive';
    }
    public function getHome()
    {
        return  $this->home_page == 1 ? 'Shown' : 'Unshown';
    }
    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
    public function subCategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    public function childrenTree()
    {
        return $this->subCategories()->with('childrenTree');
    }
    public function mainImage()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'main');
    }


    public function category_products()
    {
        return $this->hasMany('App\Models\Product' , 'category_id' , 'id')->active();
    }
    public function subcategory_products()
    {
        return $this->hasMany('App\Models\Product' , 'subcategory_id' , 'id')->active();
    }
}
