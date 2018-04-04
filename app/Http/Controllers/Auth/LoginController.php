<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request; // add kkw
use Auth; // add kkw
use Session; // add kkw
use Carbon\Carbon; // add kkw

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
    //protected $redirectTo = '/admin/dashboard';


    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    // 중복 로그인 방지 , 패스워드 만료일 체크 (2018.03.30 KKW)
    // authenticated() method is executed everytime user is successfully logs in.
    protected function authenticated(Request $request, $user)
    {
        $previous_session = $user->session_id;

        // DB에서 로그인한 아이디 session을 꺼내와서 그 session을 destroy
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        // 현재 접속된 세션을 DB에 저장
        Auth::user()->session_id = Session::getId();
        Auth::user()->save();

        // 패스워드 만료일 처리
        $password_changed_at = new Carbon(($user->password_changed_at) ? $user->password_changed_at : $user->created_at);
 
        if (Carbon::now()->diffInDays($password_changed_at) >= config('auth.password_expires_days')) {
            return redirect()->route('password.expired');
        }
       
        return redirect()->intended($this->redirectPath());
    }

}
