<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all()
    {
        try{
            $products = Product::active()->orderBy('id','desc')->get();
            return view('frontend.product.products',compact('products'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
    public function single($slug)
    {
        try{
            $product = Product::active()->where('slug' , $slug)->first();
            return view('frontend.product.product',compact('product'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
}
