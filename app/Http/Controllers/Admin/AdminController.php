<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Media;
use App\Models\Moderator;
use App\Models\Question;
use App\Notification;
use App\User;
use Request;
use Response;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.home');
    }

    public function getsubcategories()
    {
        $category_id = Request::input('category_id');
        $subcategories = Category::where('parent_id', $category_id)->get();
        return Response::json($subcategories);
    }
    public function getcities()
    {
        $country_id = Request::input('country_id');
        $cities = City::where('country_id', $country_id)->get();
        return Response::json($cities);
    }
    /************ delete not *********/
    public function readNotification()
    {
        $notificationID = Request::input('notificationID');
        $notification = Notification::where('id', $notificationID)->first();
        $notification->delete();
        return response()->json(['status' => 'success'], 201);
    }
}
