<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Models\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class wishController extends Controller
{
    public function addToWish(Request $request)
    {
        $productID = $request->input('productID');
        $found = WishList::where('product_id', $productID)->where('user_id', Auth::user()->id)->count();
        if ($found > 0) {
            WishList::where('product_id', $productID)->where('user_id', Auth::user()->id)->delete();
            return response()->json(['error' => trans('controller.delete_cart_controller')], 422);
        } else {
            $wish = new WishList;
            $wish->product_id = $productID;
            $wish->user_id = Auth::user()->id;
            $wish->save();
            return response()->json(['status' => trans('controller.succ_add')], 200);
        }
    }

    public function wishlist()
    {
        $user = User::find(Auth::user()->id);
        $wishs = WishList::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $proIds = [];
        foreach($wishs as $wish){
            array_push($proIds , $wish->product_id);
        }
        $products = Product::whereIn('id' , $proIds)->paginate(12);
        return view('frontend.wishlist', compact('wishs', 'user' , 'products'));
    }

    public function removeFromWish($wishID)
    {
        $wish = WishList::find($wishID);
        if ($wish->user_id == Auth::user()->id) {
            $wish->delete();
            session()->flash('done', trans('frontend.wishlist4'));
            return redirect()->back();
        } else {
            return redirect(route('frontendHome'));
        }
    }

    public function distroy()
    {
        WishList::where('user_id', Auth::user()->id)->delete();
        return redirect()->back();
    }
}
