<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\File;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Size;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            $products = Product::orderBy('id' , 'desc')->get();
            return view('backend.products.index', compact('products'));
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
            return view('backend.products.create' , compact('categories'));
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
    public function store(ProductRequest $request)
    {
        try {
            if($request->discount_price){
                $offerprice = $request->price;
                $offerdisc = $request->discount_price;
                $offerRate = $offerdisc / $offerprice * 100;
                $offerRate = 100 - $offerRate;
            }

            $product = new Product();
            $product->name_ar = $request->name_ar;
            $product->name_en = $request->name_en;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->kind = $request->kind;
            if($request->discount_price){
                $product->percentage_discount = round($offerRate) . ' % ';
            }else{
                $product->percentage_discount = 0;
            }
            $product->body_ar = $request->body_ar;
            $product->body_en = $request->body_en;
            if ($request->active == 1) { $product->active = 1; } else { $product->active = 0; }
            $product->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/products', $product->id , Product::class, 'main');
            }
            if ($request->hasFile('images')) {
                $this->saveimages($request->images, 'pictures/products', $product->id , Product::class, 'sub');
            }
            if ($request->hasFile('video')) {
                $this->saveimage($request->video, 'pictures/products', $product->id , Product::class, 'video');
            }
            if($product->kind == 1){
                if ($request->hasFile('file')) {
                    $this->saveimage($request->file, 'pictures/files', $product->id , Product::class, 'file');
                }
            }
            return redirect()->route('products.show' , $product->slug)->with('done', 'Added Successfully ....');
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
    public function show($slug)
    {
        try {
            $product = Product::where('slug' , $slug)->first();
            return view('backend.products.show' , compact('product'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function accept($slug)
    {
        try {
            $product = Product::where('slug' , $slug)->first();
            if($product->active == 1){
                $product->active = 0;
            }else{
                $product->active = 1;
            }
            $product->save();
            return redirect()->route('products.index')->with('done', 'Posted Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
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
            $product = Product::where('slug' , $slug)->first();
            if(isset($product)){
                $categories = Category::whereNull('parent_id')->get();
                return view('backend.products.edit' , compact('product' , 'categories'));
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
    public function update(ProductRequest $request, $id)
    {
        try {
            if($request->discount_price){
                $offerprice = $request->price;
                $offerdisc = $request->discount_price;
                $offerRate = $offerdisc / $offerprice * 100;
                $offerRate = 100 - $offerRate;
            }

            $product = Product::find($id);
            $product->name_ar = $request->name_ar;
            $product->name_en = $request->name_en;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->kind = $request->kind;
            $product->discount_price = $request->discount_price;
            if($request->discount_price){
                $product->percentage_discount = round($offerRate) . ' % ';
            }else{
                $product->percentage_discount = 0;
            }
            $product->body_ar = $request->body_ar;
            $product->body_en = $request->body_en;
            if ($request->active == 1) { $product->active = 1; } else { $product->active = 0; }
            $product->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/products', $product->id , Product::class, 'main');
            }
            if ($request->hasFile('images')) {
                $this->saveimages($request->images, 'pictures/products', $product->id , Product::class, 'sub');
            }
            if ($request->hasFile('video')) {
                $this->editimage($request->video, 'pictures/products', $product->id , Product::class, 'video');
            }
            if($product->kind == 1){
                if ($request->hasFile('file')) {
                    $this->editimage($request->file, 'pictures/files', $product->id , Product::class, 'file');
                }
            }
            return redirect()->route('products.show' , $product->slug)->with('done', 'Edited Successfully ....');
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
            $product = Product::find($id);
            if(isset($product)){
                $this->deleteimages($product->id , 'pictures/products/' , Product::class);
                $this->deleteimages($product->id , 'pictures/files/' , Product::class);
                foreach ($product->subImages as $image){
                    @unlink('pictures/products/' . $image->file);
                    $image->delete();
                }
                $product->delete();
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

    public function delete_products()
    {
        try{
            $products = Product::all();
            if(count($products) > 0){
                foreach ($products as $product){
                    $this->deleteimages($product->id , 'pictures/products/' , Product::class);
                    $this->deleteimages($product->id , 'pictures/files/' , Product::class);
                    foreach ($product->subImages as $image){
                        @unlink('pictures/products/' . $image->file);
                        $image->delete();
                    }
                    $product->delete();
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

    public function delete_images($imgID)
    {
        try{
            $image = File::find($imgID);
            @unlink('pictures/products/' . $image->file);
            $image->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
}
