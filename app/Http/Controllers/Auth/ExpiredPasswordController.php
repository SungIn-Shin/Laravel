<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;  // 날짜/시간 라이브러리 (2018.03.30 KKW)
use Hash; // 2018.03.30 KKW
use App\Http\Requests\PasswordExpiredRequest; // 2018.03.30 KKW

class ExpiredPasswordController extends Controller
{
    // 패스워드 변경 화면
    public function expired()
    {
        return view('auth.passwords.expired');
    }

    // 패스워드 변경 처리
    public function postExpired(PasswordExpiredRequest $request)
    {
        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => '현재 패스워드가 맞지 않습니다.']);
        }
 
        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString()
        ]);
        return redirect()->back()->with(['status' => '패스워드가 정상적으로 변경되었습니다.']);
    }
}
