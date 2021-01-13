<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Option;
use App\Models\Page;
use App\Models\Product;
use App\Models\Slider;
use App\Models\WishList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->middleware('auth:api')->except('categories', 'sliders','hot_offers','all_hot_offers',
            'interests','all_interests','contact_phone' ,'contact_email' , 'contact_address' , 'contact' , 'legal' ,
            'privacy' , 'chosen','all_chosen');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sliders()
    {
        try{
            $sliders = Slider::orderBy('id' , 'desc')->select(
                'id',
                'title_'.app()->getLocale().' as title',
                'subtitle_'.app()->getLocale().' as subtitle',
                'link'
            )->active()->with(array('mainImage'=>function($query){
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->get();
            if(count($sliders) > 0){
                return response()->json([
                    'status' => true,
                    'data' => $sliders,
                    'code' => 200,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد بنرات اعلانية',
                    'code' => 400,
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }

    public function categories()
    {
        try{
            $categories = Category::where('home_page' , 1)->orderBy('id' , 'desc')->select(
                'id',
                'name_'.app()->getLocale().' as name'
            )->with(array('mainImage'=>function($query){
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->active()->withCount('category_products')->get();
            $categories = $categories->slice(0,3);
            if(count($categories) > 0){
                return response()->json([
                    'status' => true,
                    'data' => $categories,
                    'code' => 200,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد تصنيفات في الرئيسية',
                    'code' => 400,
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }
///////////////////////////////////////////////////////////////////////////
    public function hot_offers(Request $request)
    {
        try {
            $hot_offers = Product::whereNotNull('percentage_discount')->orWhere('percentage_discount' , '!=' , 0)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->get();
            $products = [];
            foreach($hot_offers as $one_product){
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
                $productss = $hot_offers->slice(0,5);
            }
            if (count($hot_offers) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $productss,
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
    public function all_hot_offers(Request $request)
    {
        try {
            $hot_offers = Product::whereNotNull('percentage_discount')->orWhere('percentage_discount' , '!=' , 0)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->paginate(10);
            $products = [];
            foreach($hot_offers as $one_product){
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
            if (count($hot_offers) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $hot_offers,
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

///////////////////////////////////////////////////////////////////////////
    public function interests(Request $request)
    {
        try {
            if($request->bearerToken()){
                $user = User::where('api_token', $request->bearerToken())->first();
                $products = WishList::where('user_id' , $user->id)->with(array('product' => function ($query) {
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
                    )->active();
                }))->get();
                if(count($products) > 0){
                    $productss = $products->slice(0,5);
                    return response()->json([
                        'status' => true,
                        'data' => $productss,
                        'code' => 200,
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يوجد منتجات',
                        'code' => 400,
                    ]);
                }
            }else{
                $interests = Product::where('views' , '!=' , 0)->select(
                    'id',
                    'name_' . app()->getLocale() . ' as name',
                    'price',
                    'discount_price',
                    'percentage_discount'
                )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                        $query->select(
                            'image',
                            'imageable_id'
                        );
                    })
                )->paginate(5);
                $products = [];
                foreach($interests as $one_product){
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
                if (count($interests) > 0) {
                    $productss = $interests->slice(0,5);
                    return response()->json([
                        'status' => true,
                        'data' => $productss,
                        'code' => 200,
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد منتجات',
                    'code' => 400,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ',
                'code' => 400,
            ]);
        }
    }
    public function all_interests(Request $request)
    {
        try {
            if($request->bearerToken()){
                $user = User::where('api_token', $request->bearerToken())->first();
                $products = WishList::where('user_id' , $user->id)->with(array('product' => function ($query) {
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
                    )->active();
                }))->paginate(10);
                if(count($products) > 0){
                    return response()->json([
                        'status' => true,
                        'data' => $products,
                        'code' => 200,
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يوجد منتجات',
                        'code' => 400,
                    ]);
                }
            }else{
                $interests = Product::where('views' , '!=' , 0)->select(
                    'id',
                    'name_' . app()->getLocale() . ' as name',
                    'price',
                    'discount_price',
                    'percentage_discount'
                )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                        $query->select(
                            'image',
                            'imageable_id'
                        );
                    })
                )->paginate(10);
                $products = [];
                foreach($interests as $one_product){
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
                if (count($interests) > 0) {
                    return response()->json([
                        'status' => true,
                        'data' => $interests,
                        'code' => 200,
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد منتجات',
                    'code' => 400,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ',
                'code' => 400,
            ]);
        }
    }
///////////////////////////////////////////////////////////////////////////

    public function chosen(Request $request)
    {
        try {
            $hot_offers = Product::where('chosen' , 1)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->get();
            $products = [];
            foreach($hot_offers as $one_product){
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
            if (count($hot_offers) > 0) {
                $productss = $hot_offers->slice(0,5);
                return response()->json([
                    'status' => true,
                    'data' => $productss,
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
    public function all_chosen(Request $request)
    {
        try {
            $hot_offers = Product::where('chosen' , 1)->select(
                'id',
                'name_' . app()->getLocale() . ' as name',
                'price',
                'discount_price',
                'percentage_discount'
            )->active()->orderBy('percentage_discount', 'desc')->with(array('mainImage' => function ($query) {
                    $query->select(
                        'image',
                        'imageable_id'
                    );
                })
            )->paginate(10);
            $products = [];
            foreach($hot_offers as $one_product){
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
            if (count($hot_offers) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $hot_offers,
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
//////////////////////////////////////////////////////////
    public function privacy()
    {
        try{
            $page = Page::where('id' , 2)->select(
                'id',
                'name_'.app()->getLocale().' as name',
                'body_'.app()->getLocale().' as body'
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $page,
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
    public function legal()
    {
        try{
            $page = Page::where('id' , 1)->select(
                'id',
                'name_'.app()->getLocale().' as name',
                'body_'.app()->getLocale().' as body'
            )->active()->get();
            return response()->json([
                'status' => true,
                'data' => $page,
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

    public function contact(Request $request)
    {
        try{
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->save();
            return response()->json([
                'status' => true,
                'data' => $contact,
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
    public function contact_address()
    {
        try{
            $option = Option::find(1);
           if(app()->getLocale() == 'ar'){
               $address = $option->address_ar;
           }else{
               $address = $option->address_en;
           }
            return response()->json([
                'status' => true,
                'data' => $address,
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
    public function contact_email()
    {
        try{
            $option = Option::find(1);
            $email = $option->email;
            return response()->json([
                'status' => true,
                'data' => $email,
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
    public function contact_phone()
    {
        try{
            $option = Option::find(1);
            $phone = $option->phone;
            return response()->json([
                'status' => true,
                'data' => $phone,
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
