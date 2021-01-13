<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function facebook()
    {
        try{
           $option = Option::find(1);
           $facebook = $option->face;
            return response()->json([
                'status' => true,
                'data' => $facebook,
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
    public function social()
    {
        try{
            $option = Option::select('face as facebook' , 'whats as whatsApp' , 'insta as instagram')->where('id' , 1)->get();
            return response()->json([
                'status' => true,
                'data' => $option,
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
    public function whatsapp()
    {
        try{
            $option = Option::find(1);
            $whatsapp = $option->whats;
            return response()->json([
                'status' => true,
                'data' => $whatsapp,
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
    public function insta()
    {
        try{
            $option = Option::find(1);
            $insta = $option->insta;
            return response()->json([
                'status' => true,
                'data' => $insta,
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
