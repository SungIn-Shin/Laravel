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
use Response;
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
        $users = User::paginate(10);
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

    protected $updateUserRules = 
    [
        'email' => 'required', 
        'name'  => 'required|string|max:255',
        'current_password' => 'required',
        'password' => 'required|confirmed|min:8|max:30'/*|regex:/^.*(?=^.{8,30}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*+=]).*$/'*/, 
        'team' => 'required', 
        'position' => 'required'
    ];

    // 사용자 정보 수정
    public function updateUser(UpdateUserPost $request) 
    {
        // return Response::json(array('code' => '999'));
        
        // $validator = Validator::make($request->all(), $this->updateUserRules);
        // if($validator->fails()) {
        //     return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        // }

        $user = User::where('id', $request->id)->first();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['current_password' => '기존 패스워드가 일치하지 않습니다.']);
        }

        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->team_id = $request->team;

        $user->position_id = $request->position;
        $user->position_name = Position::where('id', $request->position)->first()->name;
        if($request->has('job')) {
            $user->job_id = $request->job;
            $user->job_name = Job::where('id', $request->job)->first()->name;
        }

        $user->save();

        return redirect()->back()->with(['status' => '사용자 정보 수정 성공']);
    }

    // 사용자 정렬 수정
    public function updateUserSort(Request $request)
    {

    }

 
}