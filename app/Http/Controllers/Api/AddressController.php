<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $user = User::where('api_token', $request->bearerToken())->first();
            $userID = $user->id;
            $addresses = Address::with(array('city'=>function($query){
                    $query->select(
                        'id',
                        'country_id',
                        'name_' . app()->getLocale() . ' as name'
                    )->active()->with(array('country'=>function($query){
                            $query->select(
                                'id',
                                'name_' . app()->getLocale() . ' as name'
                            )->active();
                        })
                    );
                })
            )->where('user_id' , $userID)->orderBy('id' , 'desc')->get();
            if(count($addresses) > 0){
                return response()->json([
                    'status' => true,
                    'data' => $addresses,
                    'code' => 200,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'لا يوجد عناوين خاصة بكـ',
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
    public function store(Request $request)
    {

            $user = User::where('api_token', $request->bearerToken())->first();
            $userID = $user->id;
            $address = new Address();
            $address->fullname = $request->fullname;
            $address->street_address = $request->street_address;
            $address->building_no = $request->building_no;
            $address->city_id = $request->city_id;
            $address->area = $request->area;
            $address->phone = $request->phone;
            if($request->active){
                $address->active = 1;
                $addresses = $user->addresses;
                foreach ($addresses as $old_address){
                    $old_address->active = 0;
                    $old_address->save();
                }
            }else{
                $address->active = 0;
            }
            $address->user_id = $userID;
            $address->save();
            return response()->json([
                'status' => true,
                'data' => $address,
                'code' => 200,
            ]);

    }
    public function show(Request $request ,$id)
    {
        try{
            $user = User::where('api_token', $request->bearerToken())->first();
            $userID = $user->id;
            $address = Address::where('id' , $id)->with(array('city'=>function($query)
                {
                    $query->select(
                        'id',
                        'country_id',
                        'name_' . app()->getLocale() . ' as name'
                    )->active()->with(array('country'=>function($query){
                            $query->select(
                                'id',
                                'name_' . app()->getLocale() . ' as name'
                            )->active();
                        })
                    );
                })
            )->where('user_id' , $userID)->orderBy('id' , 'desc')->first();
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
    public function update(Request $request, $id)
    {
        try{
            $user = User::where('api_token', $request->bearerToken())->first();
            $userID = $user->id;
            $address = Address::find($id);
            $address->fullname = $request->fullname;
            $address->street_address = $request->street_address;
            $address->building_no = $request->building_no;
            $address->city_id = $request->city_id;
            $address->area = $request->area;
            $address->phone = $request->phone;
            if($request->active){
                $addresses = $user->addresses;
                foreach ($addresses as $old_address){
                    $old_address->active = 0;
                    $old_address->save();
                }
                $address->active = 1;
            }else{
                $address->active = 0;
            }
            $address->user_id = $userID;
            $address->save();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $address = Address::find($id);
            $address->delete();
            return response()->json([
                'status' => true,
                'msg' => 'تم الحذف بنجاح',
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
    public function main($id)
    {
        try{
            $address = Address::find($id);
            $user =  $address->user;
            $addresses = $user->addresses;
            foreach ($addresses as $old_address){
                $old_address->active = 0;
                $old_address->save();
            }
            $address->active = 1;
            $address->save();

            $addresss = Address::where('id' , $id)->with(array('city'=>function($query)
                {
                    $query->select(
                        'id',
                        'country_id',
                        'name_' . app()->getLocale() . ' as name'
                    )->active()->with(array('country'=>function($query){
                            $query->select(
                                'id',
                                'name_' . app()->getLocale() . ' as name'
                            )->active();
                        })
                    );
                })
            )->orderBy('id' , 'desc')->first();
            return response()->json([
                'status' => true,
                'data' => $addresss,
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
    public function delete_all(Request $request)
    {
        try{
            $user = User::where('api_token', $request->bearerToken())->first();
            $addresses = $user->addresses;
            foreach ($addresses as $address){
                $address->delete();
            }
            return response()->json([
                'status' => true,
                'msg' => 'تم الحذف بنجاح',
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
