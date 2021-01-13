<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;
use LaravelLocalization;

class PageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->middleware('auth:api')->except('index' , 'show' , 'faq');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        try{
            $topic_faqs = Faq::select(
                'id',
                'title_'.app()->getLocale().' as title',
                'body_'.app()->getLocale().' as body'
            )->where('kind' , 1)->get();
            $popular_faqs = Faq::select(
                'id',
                'title_'.app()->getLocale().' as title',
                'body_'.app()->getLocale().' as body'
            )->where('kind' , 2)->get();
            return response()->json([
                'status' => true,
                'faqs_topics' => $topic_faqs,
                'popular_faq' => $popular_faqs,
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
            $pages = Page::select(
                'id',
                'name_'.app()->getLocale().' as name',
                'body_'.app()->getLocale().' as body',
                'active'
            )->get();
            return response()->json([
                'status' => true,
                'data' => $pages,
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
    public function show($id)
    {
        $page = Page::where('id',$id)->select(
            'id',
            'name_'.app()->getLocale().' as name',
            'body_'.app()->getLocale().' as body',
            'active'
            )->first();
        if(isset($page)) {
            return response()->json([
                'status' => true,
                'data' => $page,
                'code' => 200,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'صفحة غير موجودة',
                'code' => 400,
            ]);
        }
    }

}
