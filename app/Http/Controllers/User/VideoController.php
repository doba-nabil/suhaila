<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function all()
    {
        try{
            $videos = Video::active()->orderBy('id', 'desc')->get();
            return view('frontend.video.videos',compact('videos'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
    public function single($slug)
    {
        try{
            $video = Video::active()->where('slug' , $slug)->first();
            return view('frontend.video.video',compact('video'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
}
