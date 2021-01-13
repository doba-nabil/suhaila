<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use UploadTrait;
//    function __construct()
//    {
//        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-list', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-create', ['only' => ['create','store']]);
//        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:category-delete', ['only' => ['destroy' , 'delete_categories']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pages = Page::orderBy('id', 'desc')->where('id' , '>' , 1)->get();
            return view('backend.pages.index',compact('pages'));
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
            return view('backend.pages.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        try {
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $page = Page::create($request->all());
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/pages', $page->id , Page::class, 'main');
            }
            return redirect()->route('pages.index')->with('done', 'Added Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (isset($page)) {
            if($slug == 'about-home'){
                return view('backend.pages.home', compact('page'));
            }else{
                return view('backend.pages.edit', compact('page'));
            }

        } else {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        try {
            $page = Page::find($id);
            if($request->active || $id == 1){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $page->update($request->all());
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/pages', $page->id , Page::class, 'main');
            }
            if($id == 1){
                return redirect()->back()->with('done', 'Edited Successfully');
            }else{
                return redirect()->route('pages.index')->with('done', 'Edited Successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $page = Page::find($id);
            if($page->id > 2){
                $this->deleteimages($page->id , 'pictures/pages/' , Page::class);
                $page->delete();
            }else{
                return response()->json([
                    'error' => 'you can\'t delete this pages'
                ],422);
            }
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error Try Again !!'
            ],422);
        }

    }

    public function delete_pages()
    {
        try {
            $pages = Page::where('id' , '>' , 2)->get();
            if (count($pages) > 0) {
                foreach ($pages as $page) {
                    $this->deleteimages($page->id , 'pictures/pages/' , Page::class);
                    $page->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO EVENTS TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error Try Again !!'
            ],422);
        }
    }
}
