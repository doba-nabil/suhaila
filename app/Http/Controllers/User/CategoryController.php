<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Video;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function single($slug)
    {
        try{
            $category = Category::active()->where('slug',$slug)->first();
            $videos = Video::active()->where('category_id' , $category->id)->orderBy('id','desc')->get();
            $products = Product::active()->where('category_id' , $category->id)->orderBy('id','desc')->get();
            return view('frontend.category.category-single',compact('category','videos','products'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
    public function all()
    {
        try{
            $categories = Category::active()->orderBy('id','desc')->get();
            return view('frontend.category.categories',compact('categories'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }

}
