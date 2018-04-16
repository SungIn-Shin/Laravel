<?php

namespace App\Http\Controllers;
use Debugbar;
use Redirect;
use App\User;
use App\Position;
use App\Rank;
use App\Team;
use App\Role;
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
        $ranks = Rank::orderBy('sortkey', 'asc')->get();
        $positions = Position::orderBy('sortkey', 'asc')->get();
        $roles = Role::orderBy('id', 'asc')->get();
        $teams = Team::all();

        return view('iheart.admin.user.regist')->with([ 'positions' => $positions, 
                                                        'ranks'     => $ranks, 
                                                        'roles'     => $roles, 
                                                        'teams'     => $teams
                                                    ]);
    }

    // 사용자 등록
    public function userRegist(StoreUserPost $request)
    {
        // dd($request);
        $user = new User;

        $user->team_id = $request->team;

        $user->rank_id = $request->rank;
        
        $rank = Rank::where('id', $request->rank)->first();
        $user->rank_name = $rank->name;

        // if($request->has('job')) {
        if($request->has('position')) {
            $user->position_id = $request->position;
            $position = Position::where('id', $request->position)->first();
            $user->position_name = $position->name;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->otpkey = $request->otpkey; // 2018.04.09 KKW
        
        $user->save();

        // 사용자 권한 추가
        $user->attachRole($request->role);

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

        $ranks = Rank::orderBy('sortkey', 'asc')->get();
        $positions = Position::orderBy('sortkey', 'asc')->get();
        $roles = Role::orderBy('id', 'asc')->get();
        $teams = Team::all();
        return view('iheart.admin.user.detail')->with([ "user" => $user, 
                                                        'positions' => $positions, 
                                                        'ranks' => $ranks, 
                                                        'roles' => $roles,
                                                        'teams' => $teams
                                                    ]);
    }

    // 사용자 정보 수정
    public function adminUpdateUser(Request $request) 
    {
        // 기존 패스워드 확인 절차. 슈퍼유저가 일반 사용자 수정시에 필요없어서 주석처리 - modified by ssi - 2018-04-05
        // $user = User::where('id', $request->id)->first();
        // if (!Hash::check($request->current_password, $user->password)) {
        //     return redirect()->back()->with(['current_password' => '기존 패스워드가 일치하지 않습니다.']);
        // }
        $updateUserRules = [];
        if($request->has('password') || $request->has('password_confirmation')) {
            // 패스워드 입력시 패스워드도 같이 validation
            $updateUserRules = [
                'email'     => 'required', 
                'name'      => 'required|string|max:255',
                'password'  => 'required|confirmed|min:8|max:30'/*|regex:/^.*(?=^.{8,30}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*+=]).*$/'*/, 
                'team'      => 'required', 
                'rank'      => 'required', 
                'role'      => 'required',
                'otpkey'    => 'nullable|min:16|max:16', // 2018.04.09 KKW
            ];
        } else {
            // 패스워드 미입력시 패스워드는 validation 제외
            $updateUserRules = [
                'email'     => 'required', 
                'name'      => 'required|string|max:255',
                'team'      => 'required', 
                'rank'      => 'required',
                'role'      => 'required',
                'otpkey'    => 'nullable|min:16|max:16', // 2018.04.09 KKW
            ];
        }

        $validation = Validator::make($request->all(), $updateUserRules);

        if (!$validation->fails()) {
            $user = User::where('id', $request->id)->first();
            $user->name = $request->name;
            if($request->has('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->team_id = $request->team;

            $user->rank_id = $request->rank;
            $user->rank_name = Rank::where('id', $request->rank)->first()->name;
            if($request->has('position')) {
                $user->position_id = $request->position;
                $user->position_name = Position::where('id', $request->position)->first()->name;
            }
            $user->otpkey = $request->otpkey; // 2018.04.09 KKW

            // 사용자의 기존 권한 제거 후 다시 권한 부여.
            // users(n) : roles(m) 구조이기에 1개의 권한만 주기위한 작업.
            // 기존 권한 제거
            $user->detachRoles($user->roles);
            // 새로운 권한 부여
            $user->roles()->attach($request->role);

            $user->save();

            return redirect()->back()->with(['status' => '사용자 정보 수정 성공']);
        } else {
            return redirect()->back()->withErrors($validation);
        }

        
    }

    // 사용자 정렬 수정
    public function adminUpdateUserSort(Request $request)
    {
        
    }

 
}