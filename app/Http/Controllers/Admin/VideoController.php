<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Category;
use App\Models\Video;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $videos = Video::orderBy('id' , 'desc')->get();
            return view('backend.videos.index', compact('videos'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $categories = Category::whereNull('parent_id')->get();
            return view('backend.videos.create' , compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        try {
            $video = new Video();
            $video->name_ar = $request->name_ar;
            $video->name_en = $request->name_en;
            $video->category_id = $request->category_id;
            $video->body_ar = $request->body_ar;
            $video->body_en = $request->body_en;
            if ($request->active == 1) { $video->active = 1; } else { $video->active = 0; }
            if ($request->home == 1) { $video->home = 1; } else { $video->home = 0; }
            $video->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/videos', $video->id , Video::class, 'image');
            }
            if ($request->hasFile('video')) {
                $this->saveimage($request->video, 'pictures/videos', $video->id , Video::class, 'video');
            }
            return redirect()->route('videos.index')->with('done', 'Added Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        try {
            $video = Video::where('slug' , $slug)->first();
            if(isset($video)){
                $categories = Category::whereNull('parent_id')->get();
                return view('backend.videos.edit' , compact('video' , 'categories'));
            }else{
                return redirect()->back()->with('error', 'Error Try Again !!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, $id)
    {
        try {
            $video = Video::find($id);
            $video->name_ar = $request->name_ar;
            $video->name_en = $request->name_en;
            $video->category_id = $request->category_id;
            $video->body_ar = $request->body_ar;
            $video->body_en = $request->body_en;
            if ($request->active == 1) { $video->active = 1; } else { $video->active = 0; }
            if ($request->home == 1) { $video->home = 1; } else { $video->home = 0; }
            $video->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/videos', $video->id , Video::class, 'image');
            }
            if ($request->hasFile('video')) {
                $this->editimage($request->video, 'pictures/videos', $video->id , Video::class, 'video');
            }
            return redirect()->route('videos.index')->with('done', 'Edited Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $video = Video::find($id);
            if(isset($video)){
                $this->deleteimages($video->id , 'pictures/videos/' , Video::class);
                $video->delete();
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            }else{
                return redirect()->back()->with('error', 'Error Try Again !!');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    public function delete_videos()
    {
        try{
            $videos = Video::all();
            if(count($videos) > 0){
                foreach ($videos as $video){
                    $this->deleteimages($video->id , 'pictures/videos/' , Video::class);
                    $video->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            }else{
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
}
