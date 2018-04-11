<?php

namespace App\Http\Controllers;

use App\Loginhistory;
use Illuminate\Http\Request;

class LogController extends Controller
{

    // 로그인로그 리스트 조회 (2018.04.11 KKW)
    public function loginList(Request $request) 
    {
        $loginhistory = new Loginhistory();
        $loginhistories = $loginhistory->index($request);
        // 검색조건값을 되돌림
        return view('iheart.admin.log.loginList')->with( array("loginhistories" => $loginhistories, 'request' => $request) );
    }

}