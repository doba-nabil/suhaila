<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Pay;
use App\Models\Product;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use UploadTrait;

    public function productcart(Request $request)
    {
        try{
            $id = $request->input('product_id');
            $product = Product::find($id);
            if(Auth::user()){
                $user_id = Auth::user()->id;
               $pay = Pay::where('user_id' , $user_id)->where('product_id',$id)->first();
               if(isset($pay) && $product->kind == 1){
                   return response()->json(['error' => trans('controller.paid_before')], 422);
               }
            }
            if($product->kind == 1){
                $found = Cart::content()->where('id', $id);
                if(count($found) > 0){
                    return response()->json(['error' => trans('controller.added_before')], 422);
                }else{
                    if(empty($product->discount_price)){
                        Cart::add(['id' => $product->id , 'name' => $product['name_' . app()->getLocale()] ,'qty' => 1,  'price' =>  $product->price ]);
                    }else{
                        Cart::add(['id' => $product->id , 'name' => $product['name_' . app()->getLocale()] ,'qty' => 1,  'price' =>  $product->discount_price ]);
                    }
                    return response()->json(['status' => trans('controller.succ_add')], 200);
                }
            }else{
                if(empty($product->discount_price)){
                    Cart::add(['id' => $product->id , 'name' => $product['name_' . app()->getLocale()] ,'qty' => 1,  'price' =>  $product->price ]);
                }else{
                    Cart::add(['id' => $product->id , 'name' => $product['name_' . app()->getLocale()] ,'qty' => 1,  'price' =>  $product->discount_price ]);
                }
                return response()->json(['status' => trans('controller.succ_add')], 200);
            }
        }catch (\Exception $e){
            return response()->json(['error' => trans('controller.error')], 422);
        }
    }
    public function edit_cart(request $request)
    {
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');
        if ($qty !== 0 ){
            Cart::update($rowId,
                $qty
            );
        }
        $price = Cart::total();
        return response()->json($price, 200);

    }
    public function cart()
    {
        try{
            return view('frontend.cart');
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
    public function clear_cart()
    {
        try{
          if(count(Cart::content()) > 0 ){
              Cart::destroy();
              return response()->json(['status' => trans('controller.cleared_cart')], 200);
          }else{
              return response()->json(['error' => trans('controller.empty_cart_controller')], 422);
          }
        }catch (\Exception $e){
            return response()->json(['error' => trans('controller.error')], 422);
        }
    }
    public function remove(Request $request)
    {
        try{
            $id = $request->input('row_id');
            Cart::remove($id);
            return response()->json(['status' => trans('controller.delete_cart_controller')], 200);
        }catch (\Exception $e){
            return response()->json(['error' => trans('controller.error')], 422);
        }
    }

    public function make_order(Request $request)
    {
        try{
            if(count(Cart::Content()) > 0){
                $dt = Carbon::now();
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->time = $dt->toTimeString();
                $order->date = $dt->toDateString();
                $order->phone = Auth::user()->phone;
                $order->order_no = rand();
                $order->total_price = Cart::subtotal();

                $order->paid_type = $request->paid_type;

                $order->street_address = $request->street_address;
                $order->building_no = $request->building_no;
                $order->city_id = $request->city_id;
                $order->area = $request->area;
                $order->address_phone = $request->phone;
                $order->fullname = $request->fullname;

                $order->paid_type = $request->paid_type;
                if($request->paid_type == 1){
                    $order->bank_id = $request->bank_id;
                }
                $order->save();
                if($request->paid_type == 1){
                    if ($request->hasFile('image')) {
                        $this->saveimage($request->image, 'pictures/orders', $order->id , Order::class, 'pay');
                    }
                }
                foreach (Cart::Content() as $row){
                    $pay = new Pay();
                    $pay->order_id = $order->id;
                    $pay->count = $row->qty;
                    $pay->user_id = Auth::user()->id;
                    $pay->product_id = $row->id;
                    $pay->save();
                }
                Cart::destroy();
                return redirect()->route('home')->with('done' , trans('controller.order_succ'));
            }else{
                return redirect()->back()->with('error' , trans('controller.empty_cart_controller'));
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error' , trans('controller.error'));
        }
    }
}
