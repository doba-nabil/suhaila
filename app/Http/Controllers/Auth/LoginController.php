<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }

    public function loginapi(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();
            $userr = $user->select('id' , 'name' , 'email' , 'active','api_token')->first();
            return response()->json([
                'status' => true,
                'data' => $user,
                'code' => 200,
            ]);
        }
        return response()->json([
            'status' => false,
            'msg' => 'مستخدم غير موجود',
            'code' => 400,
        ]);
    }
    public function logoutapi(Request $request){
        if ($request->bearerToken()) {
            Auth::logout();
            return response()->json([
                'status' => true,
                'msg' => 'تم تسجيل الخروج',
                'code' => 200,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'يوجد خطأ',
                'code' => 400,
            ]);
        }
    }
}
