<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        try{
            $page = Page::find(2);
            return view('frontend.page',compact('page'));
        }catch(\Exception $e){
            return redirect()->back();
        }
    }
    public function page($slug)
    {
        try{
            $page = Page::where('slug' , $slug)->active()->first();
            return view('frontend.page',compact('page'));
        }catch(\Exception $e){
            return redirect()->back();
        }
    }
}
