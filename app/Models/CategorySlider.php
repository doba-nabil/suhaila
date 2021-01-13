<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySlider extends Model
{
    protected $fillable = [
        'image','category_id', 'active' ,'created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at','category_id'
    ];
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'Active' : 'Unactive';
    }
    public function mainImage()
    {
        return $this->morphOne('App\Models\Image', 'imageable', 'imageable_type', 'imageable_id')->where('type' , 'main');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category' , 'category_id');
    }
}
