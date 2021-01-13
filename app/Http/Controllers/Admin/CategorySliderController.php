<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorySliderRequest;
use App\Models\Category;
use App\Models\CategorySlider;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CategorySliderController extends Controller
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
            $sliders = CategorySlider::orderBy('id', 'desc')->get();
            return view('backend.category_sliders.index',compact('sliders'));
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
            $categories = Category::all();
            return view('backend.category_sliders.create' , compact('categories'));
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
    public function store(CategorySliderRequest $request)
    {
        try{
            $categorySlider = new CategorySlider();
            $categorySlider->title_ar = $request->title_ar;
            $categorySlider->title_en = $request->title_en;
            $categorySlider->subtitle_ar = $request->subtitle_ar;
            $categorySlider->subtitle_en = $request->subtitle_en;
            $categorySlider->category_id = $request->category_id;
            if ($request->active) {
                $categorySlider->active = 1;
            } else {
                $categorySlider->active = 0;
            }
            $categorySlider->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/categories_slider', $categorySlider->id , CategorySlider::class, 'main');
            }
            return redirect()->route('category_sliders.index')->with('done', 'Added Successfully ....');
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
    public function edit($id)
    {
        $slider = CategorySlider::find($id);
        if (isset($slider)) {
            $categories = Category::all();
            return view('backend.category_sliders.edit', compact('slider','categories'));
        } else {
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
    public function update(CategorySliderRequest $request, $id)
    {
        try {
            $slider = CategorySlider::find($id);
            $slider->title_ar = $request->title_ar;
            $slider->title_en = $request->title_en;
            $slider->subtitle_ar = $request->subtitle_ar;
            $slider->subtitle_en = $request->subtitle_en;
            $slider->category_id = $request->category_id;
            if ($request->active) {
                $slider->active = 1;
            } else {
                $slider->active = 0;
            }
            $slider->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/categories_slider', $slider->id , CategorySlider::class, 'main');
            }
            return redirect()->route('category_sliders.index')->with('done', 'Added Successfully ....');
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
            $slider = CategorySlider::find($id);
            $this->deleteimages($slider->id , 'pictures/categories_slider/' , CategorySlider::class);
            $slider->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function delete_category_sliders()
    {
        try {
            $sliders = CategorySlider::all();
            if (count($sliders) > 0) {
                foreach ($sliders as $slider) {
                    $this->deleteimages($slider->id , 'pictures/categories_slider/' , CategorySlider::class);
                    $slider->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
}
