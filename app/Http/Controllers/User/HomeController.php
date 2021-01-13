<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Subscribe;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try{
            $sliders = Slider::active()->orderBy('id','desc')->get();
            $categories = Category::active()->home()->paginate(6);
            $videos = Video::active()->home()->orderBy('id','desc')->paginate(20);
            return view('frontend.home',compact('sliders','categories','videos'));
        }catch(\Exception $e){
            return redirect()->back();
        }
    }
    public function contact()
    {
        try{
            return view('frontend.contact');
        }catch(\Exception $e){
            return redirect()->back();
        }
    }
    public function send_contact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
            'name' => 'required',
        ]);
        try{
            $contact = new Contact();
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->name = $request->name;
            $contact->save();
            return redirect()->back()->with('done',trans('controller.sent_succ'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    public function send_email(Request $request)
    {

        try{
            $this->validate($request, [
                'email' => 'required|email',
            ]);
            $emaill = $request->input('email');
            $found = Subscribe::where('email', $emaill)->get();
            if(count($found) > 0){
                return response()->json(['error' => trans('controller.already_exists')], 422);
            }else{
                $email = new Subscribe();
                $email->email = $emaill;
                $email->save();
                return response()->json(['status' => trans('controller.succ_subscribe')], 200);
            }
        }catch (\Exception $e){
            return response()->json(['error' => trans('controller.add_mail')], 422);
        }
    }
    public function search(Request $request)
    {
        try{
            $word = $request->word;
            $products = Product::active()->orderBy('id','desc');
            $products = $products->where(function($query) use ($word){
                $query->where('name_ar', 'like', '%' . $word . '%')
                    ->orWhere('name_en', 'like', '%' . $word . '%');
            });
            $products = $products->get();
            return view('frontend.search',compact('products','word'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
}
