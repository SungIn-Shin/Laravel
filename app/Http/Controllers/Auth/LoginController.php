<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request; // add kkw
use Auth; // add kkw
use Session; // add kkw
use Carbon\Carbon; // add kkw
use Facades\PragmaRX\Google2FA\Google2FA; // add kkw
use Hash; // add kkw
use App\User; // add kkw
use App\Loginhistory; // add kkw

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

    // 주석 kkw
    //use AuthenticatesUsers;

    // 수정 KKW
    use AuthenticatesUsers {
        login as traitlogin;
    }

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

    // 성공실패 이력 (2018.04.06 KKW)
    // otp 인증 (2018.04.06 KKW)
    public function login(Request $request)
    {
        $loginhistory = new Loginhistory;

        $loginhistory->gubun = "U";
        $loginhistory->successyn = "Y";
        
        // 계정 찾기 와 otp 인증 확인
        $otpkey = $request->otpkey;
        $window = 4; //default
        $otpfail = false;
        $findfail = false;
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            $loginhistory->successyn = "N";
            $findfail = true;
        } else {
            if (is_null($user->otpkey)) {
                $loginhistory->successyn = "N";
                $otpfail = true;
            } else {
                if (!Google2FA::verifyKey($user->otpkey, $otpkey, $window)) {
                    $loginhistory->successyn = "N";
                    $otpfail = true;
                }
            }
        }

        // 사용여부 확인 (2018.04.13 KKW)
        $useflagfail = false;
        if (!$findfail) {
            if ($user->useyn == 'N') {
                $loginhistory->successyn = "N";
                $useflagfail = true;
            }
        }

        $loginhistory->store($request, $loginhistory);

        if ($findfail) {
            return redirect('/login')->withErrors(['email' => trans('auth.failed')]);
        }
        if ($useflagfail) { // (2018.04.13 KKW)
            return redirect('/login')->withErrors(['email' => '사용이 불가능한 계정입니다.']);
        }
        if ($otpfail) {
            Session::getHandler()->destroy(Session::getId());
            return redirect('/login')->withErrors(['otpkey' => trans('auth.failed')]);
        }

        if (Hash::check($request->password, $user->password)) {
            // Authentication passed...
            $loginhistory->successyn = "Y";
        } else {
            $loginhistory->successyn = "N";
        }

        return $this->traitlogin($request);
    }

}
