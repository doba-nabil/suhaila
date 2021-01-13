<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChooseConuntry;
use App\Models\Color;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Material;
use App\Models\Product;
use App\Models\Size;
use App\Models\WishList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->middleware('auth:api')->except('show', 'similar', 'views' ,'types', 'materials' , 'brands',
            'sizes','colors','search');
    }

    public function show($id, Request $request)
    {
        $product = Product::with(array('subcategory' => function ($query) {
            $query->select(
                'id',
                'name_' . app()->getLocale() . ' as name'
            )->active();
        }))->with(array('brand' => function ($query) {
            $query->select(
                'id',
                'name_' . app()->getLocale() . ' as name'
            )->active();
        }))->with(array('material' => function ($query) {
            $query->select(
                'id',
                'name_' . app()->getLocale() . ' as name'
            )->active();
        }))->with(array('sizes.size' => function ($query) {
            $query->select(
                'id',
                'code'
            )->active();
        }))->with(array('colors.color' => function ($query) {
            $query->select(
                'id',
                'color',
                'name_' . app()->getLocale() . ' as name'
            )->active();
        }))
            ->where('id', $id)->select(
                'id',
                'subcategory_id',
                'brand_id',
                'material_id',
                'price',
                'discount_price',
                'percentage_discount',
                'min_qty',
                'max_qty',
                'code',
                'name_' . app()->getLocale() . ' as name',
                'body_' . app()->getLocale() . ' as body',
                'chosen'
            )->active()->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->with(array('subImages' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->first();
        $product->views = $product->views + 1;
        $product->save();
        $products = [];
        if ($request->bearerToken()) {
            $user = User::where('api_token', $request->bearerToken())->first();
            $found = WishList::where('product_id', $product->id)->where('user_id', $user->id)->first();
            if (isset($found)) {
                $product['isFav'] = 1;
            } else {
                $product['isFav'] = 0;
            }
        } else {
            $product['isFav'] = 0;
        }
        array_push($products, $product);
        if (isset($product)) {
            return response()->json([
                'status' => true,
                'data' => $products,
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'منتج غير موجودة',
                'code' => 400,
            ]);
        }
    }

    public function similar($id,Request $request)
    {
        try {
            $product = Product::where('id', $id)->first();
            $similar_products = Product::where('subcategory_id', $product->subcategory_id)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->active()->where('id', '!=', $id)->orderBy('id', 'desc')->get();
            $products = [];
            foreach($similar_products as $one_product){
                $product = $one_product;
                if ($request->bearerToken()) {
                    $user= User::where('api_token', $request->bearerToken())->first();
                    $found = WishList::where('product_id', $one_product->id)->where('user_id', $user->id)->first();
                    if (isset($found)) {
                        $product['isFav'] = 1;
                    } else {
                        $product['isFav'] = 0;
                    }
                } else {
                    $product['isFav'] = 0;
                }
                array_push($products,$product);
            }
            if (count($similar_products) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $products,
                    'code' => 200,
                ]);
            }
            return response()->json([
                'status' => false,
                'msg' => 'لا يوجد منتجات متشابهة',
                'code' => 400,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ',
                'code' => 400,
            ]);
        }

    }
    public function views($id)
    {
        try {
            $product = Product::where('id', $id)->first();
            $last_views = Product::where('subcategory_id', $product->subcategory_id)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->active()->where('id', '!=', $id)->orderBy('id', 'desc')->get();
            if (count($last_views) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $last_views,
                    'code' => 200,
                ]);
            }
            return response()->json([
                'status' => false,
                'msg' => 'لا يوجد منتجات',
                'code' => 400,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ',
                'code' => 400,
            ]);
        }

    }

    public function types()
    {
        try{
            $types = Category::whereNotNull('parent_id')->with(array('subcategory_products'=>function($query){
                $query->select(
                    'id',
                    'subcategory_id',
                    'price',
                    'discount_price',
                    'percentage_discount',
                    'min_qty',
                    'max_qty',
                    'code',
                    'name_'.app()->getLocale().' as name',
                    'chosen'
                )->with(array('mainImage' => function ($query) {
                        $query->select(
                            'image',
                            'imageable_id'
                        );
                    })
                )->with('wishes')->active();
            }))->select(
                'id',
                'name_'.app()->getLocale().' as name'
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $types,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }

    public function materials()
    {
        try{
            $materials = Material::with(array('products'=>function($query){
                $query->select(
                    'id',
                    'price',
                    'material_id',
                    'discount_price',
                    'percentage_discount',
                    'min_qty',
                    'max_qty',
                    'code',
                    'name_'.app()->getLocale().' as name',
                    'chosen'
                )->with(array('mainImage' => function ($query) {
                        $query->select(
                            'image',
                            'imageable_id'
                        );
                    })
                )->with('wishes')->active();
            }))->select(
                'id',
                'name_'.app()->getLocale().' as name'
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $materials,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }
    public function brands()
    {
        try{
            $brands = Brand::with(array('products'=>function($query){
                $query->select(
                    'id',
                    'price',
                    'brand_id',
                    'discount_price',
                    'percentage_discount',
                    'min_qty',
                    'max_qty',
                    'code',
                    'name_'.app()->getLocale().' as name',
                    'chosen'
                )->with(array('mainImage' => function ($query) {
                        $query->select(
                            'image',
                            'imageable_id'
                        );
                    })
                )->with('wishes')->active();
            }))->select(
                'id',
                'name_'.app()->getLocale().' as name'
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $brands,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }
    public function sizes()
    {
        try{
            $categories = Size::with(array('productDetails'=>function($query){
                $query->select(
                    'id',
                    'product_id',
                    'size_id'
                )->with(array('product'=>function($query){
                    $query->select(
                        'id',
                        'price',
                        'brand_id',
                        'discount_price',
                        'percentage_discount',
                        'min_qty',
                        'max_qty',
                        'code',
                        'name_'.app()->getLocale().' as name',
                        'chosen'
                    )->with(array('mainImage' => function ($query) {
                            $query->select(
                                'image',
                                'imageable_id'
                            );
                        })
                    );
                }));
            }))->active()->get();
            return response()->json([
                'status' => true,
                'data' => $categories,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }

    public function colors()
    {
        try{
            $categories = Color::select( 'id', 'name_'.app()->getLocale().' as name' , 'active','color')->with(array('productDetails'=>function($query){
                $query->select(
                    'id',
                    'product_id',
                    'color_id'
                )->with(array('product'=>function($query){
                    $query->select(
                        'id',
                        'price',
                        'discount_price',
                        'percentage_discount',
                        'min_qty',
                        'max_qty',
                        'code',
                        'name_'.app()->getLocale().' as name',
                        'chosen'
                    )->with(array('mainImage' => function ($query) {
                            $query->select(
                                'image',
                                'imageable_id'
                            );
                        })
                    );
                }));
            }))->active()->get();
            return response()->json([
                'status' => true,
                'data' => $categories,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }

    public function search(Request $request)
    {
        try{
            $word = $request->word;
            $products =  Product::where('name_ar', 'LIKE', "%$word%")->orWhere('name_en', 'LIKE', "%$word%")->select(
                'id',
                'subcategory_id',
                'price',
                'discount_price',
                'percentage_discount',
                'min_qty',
                'max_qty',
                'code',
                'name_'.app()->getLocale().' as name',
                'chosen'
            )->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $products,
                'code' => 200,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }
}
