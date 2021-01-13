<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\User;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function favourites(Request $request)
    {
        try {
            $user = User::where('api_token', $request->bearerToken())->first();
            $products = WishList::where('user_id', $user->id)->with(array('product' => function ($query) {
                $query->select(
                    'id',
                    'subcategory_id',
                    'price',
                    'discount_price',
                    'percentage_discount',
                    'min_qty',
                    'max_qty',
                    'code',
                    'name_' . app()->getLocale() . ' as name',
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
                return response()->json([
                    'status' => true,
                    'data' => $products,
                    'code' => 200,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد منتجات في المفضلة',
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

    public function add_delete_wishlist(Request $request)
    {
        try{
            $productID = $request->product_id;
            $user = User::where('api_token', $request->bearerToken())->first();
            $userID = $user->id;
            $found = WishList::where('product_id', $productID)->where('user_id', $userID)->count();
            if ($found > 0) {
                WishList::where('product_id', $productID)->where('user_id', $userID)->delete();
                return response()->json(['status' => 'removed']);
            } else {
                $wish = new WishList;
                $wish->product_id = $productID;
                $wish->user_id = $userID;
                $wish->save();
                return response()->json(['status' => 'added'], 200);
            }
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ يرجى المحاولة مرة اخرى',
                'code' => 400,
            ]);
        }
    }
}
