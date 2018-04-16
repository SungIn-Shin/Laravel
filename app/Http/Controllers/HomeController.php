<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $redirectPath = "";
        if($user->hasRole('admin')) {
            return redirect()->route('iheart.admin.users.show');
        }
        else if($user->hasRole('team_leader')) {
            return redirect()->route('iheart.team_leader.list');
        }
        else if ($user->hasRole('employee')) {
            return redirect()->route('iheart.employee.list');
        }
        else if ($user->hasRole('support_leader')) {
            return redirect()->route('iheart.support_leader.documents.list');
        }
        else {
            return view('home');
        }

        
    }
}
