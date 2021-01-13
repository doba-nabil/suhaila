<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pay;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = Order::orderBy('id', 'desc')->get();
            return view('backend.orders.index' , compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function new()
    {
        try {
            $orders = Order::where('new' , 1)->orderBy('id' , 'desc')->get();
            return view('backend.orders.new' , compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function old()
    {
        try {
            $orders = Order::where('new' , 0)->orderBy('id' , 'desc')->get();
            return view('backend.orders.old' , compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    public function print(Request $request,$orderId)
    {
        try {
            $received = $request->received;
            $att = $request->att;
            $bill_no = $request->bill_no;
            $order = Order::find($orderId);
            return view('backend.orders.print' , compact('order','received','att','bill_no'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $order = Order::find($id);
            $order->new = 0;
            $order->save();

            $pays = Pay::where('order_id' , $id)->get();
            return view('backend.orders.show' , compact('order','pays'));
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $order = Order::find($id);
            $order->status = $request->status;
            $order->save();

            return redirect()->back()->with('done' , 'Order Updated Successfully');
        }catch (\Exception $e){
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
        try{
            $order = Order::find($id);
            $order->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    public function delete_orders()
    {
        try {
            $orders = Order::all();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $order->delete();
                }
                return response()->json([
                    'success' => 'Records deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Records TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function delete_old_orders()
    {
        try {
            $orders = Order::where('new' , 0)->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $order->delete();
                }
                return response()->json([
                    'success' => 'Records deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Records TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function delete_new_orders()
    {
        try {
            $orders = Order::where('new' , 1)->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $order->delete();
                }
                return response()->json([
                    'success' => 'Records deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Records TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
}
