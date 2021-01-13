<?php

namespace App\Http\Controllers\Api;

use App\Models\ChooseConuntry;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function cities()
    {
        try{
           $cities = City::active()->select(
               'id',
               'country_id',
               'name_' . app()->getLocale() . ' as name'
           )->with(array('country' => function ($query) {
                $query->select(
                    'id',
                    'code',
                    'name_' . app()->getLocale() . ' as name'
                );
            }))->orderBy('id' , 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $cities,
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

    public function index()
    {
        try{
            $country_ids = [];
            $currencies = Currency::all();
            foreach ($currencies as $currency){
                array_push($country_ids , $currency->country_id);
            }
            $countries = Country::whereIn('id' , $country_ids)->active()->select(
                'id',
                'name_' . app()->getLocale() . ' as name'
            )->orderBy('id' , 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $countries,
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

    public function choose_country(Request $request)
    {
        try{
            $old_chose = ChooseConuntry::where('device_token' , $request->header('device_token'))->first();
            if(isset($old_chose)){
                return response()->json([
                    'status' => false,
                    'msg' => 'تم اختيار اللغة مسبقا',
                    'code' => 400,
                ]);
            }else{
                $chose_country = new ChooseConuntry();
                $chose_country->device_token = $request->header('device_token');
                $chose_country->country_id = $request->header('country_id');
                $chose_country->save();
                return response()->json([
                    'status' => true,
                    'data' => $chose_country,
                    'code' => 200,
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
    public function change_country(Request $request)
    {
        try{
            $chose_country = ChooseConuntry::where('device_token' , $request->header('device_token'))->first();
            $chose_country->country_id = $request->header('country_id');
            $chose_country->save();
            return response()->json([
                'status' => true,
                'data' => $chose_country,
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
