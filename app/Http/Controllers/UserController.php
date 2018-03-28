<?php

namespace App\Http\Controllers;
use Debugbar;
use Redirect;
use App\User;
use App\Position;
use App\Job;
use App\Team;
use Validator;
use Auth;
use Hash;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPost;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 사용자 등록 폼
    public function userRegistForm() 
    {
        $positions = Position::orderBy('sortkey', 'desc')->get();
        $jobs = Job::orderBy('sortkey', 'desc')->get();
        $teams = Team::all();

        return view('iheart.admin.user.regist')->with([ 'positions' => $positions, 
                                                        'jobs' => $jobs, 
                                                        'teams' => $teams
                                                    ]);
    }

    // 사용자 등록
    public function userRegist(StoreUserPost $request)
    {
        // dd($request);
        $user = new User;

        $user->team_id = $request->team;

        $user->position_id = $request->position;
        
        $position = Position::where('id', $request->position)->first();
        $user->position_name = $position->name;

        if($request->has('job')) {
            $user->job_id = $request->job;
            $job = Job::where('id', $request->job_id)->first();
            $user->job_name = $job->name;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        

        $user->save();

        return redirect()->route('iheart.admin.users.show');
    }

    // 사용자 리스트 조회
    public function showUsers(Request $request) 
    {
        $users = User::paginate(5);
        return view('iheart.admin.user.list')->with(["users" => $users]);
    }

    // 사용자 정보 상세보기
    public function detailUser($user_id) 
    {
        $user = User::where('id', $user_id)->first();

        $positions = Position::orderBy('sortkey', 'desc')->get();
        $jobs = Job::orderBy('sortkey', 'desc')->get();
        $teams = Team::all();
        return view('iheart.admin.user.detail')->with([ "user" => $user, 
                                                        'positions' => $positions, 
                                                        'jobs' => $jobs, 
                                                        'teams' => $teams]
                                                    );
    }

    // 사용자 정보 수정
    public function updateUser(Request $request) 
    {
        dump(Hash::check($request->current_password, User::where('id', $request->id)->first()->password));
        if (!Hash::check($request->current_password, User::where('id', $request->id)->first()->password)) {
            return Redirect::back()->withErrors(['current_password', 'Invalid password']);   
        }
    }

    // 사용자 정렬 수정
    public function updateUserSort(Request $request)
    {

    }

 
}