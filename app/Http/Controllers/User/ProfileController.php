<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\WishList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        try{
            $id = Auth::User()->id;
            $user = User::find($id);
            $proIds = [];
            $wishs = WishList::where('user_id' , $id)->orderBy('id' , 'desc')->get();
            foreach ($wishs as $wish){
                array_push($proIds , $wish->product_id);
            }
            $products = Product::whereIn('id' , $proIds)->get();
            return view('frontend.profile.main',compact('user','products'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
    public function purchases()
    {
        try{
            $id = Auth::User()->id;
            $orders = Order::where('user_id' , $id)->orderBy('id' , 'desc')->get();
            $proIds = [];
            foreach ($orders as $order){
                foreach ($order->pays as $pay){
                    array_push($proIds , $pay->product_id);
                }
            }
            $products = Product::whereIn('id' , $proIds)->get();
            return view('frontend.orders',compact('products' , 'orders'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    public function edit_profile(Request $request)
    {
        $id = Auth::User()->id;
        $user = User::find($id);
        $this->validate($request, [
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
        ]);
        try{
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->name = $request->name;
            $user->save();
            return redirect()->back()->with('done',trans('controller.save_succ'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
}
