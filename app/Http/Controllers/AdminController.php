<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // 사용자 등록 폼
    public function registForm() {        
        Log::info('여긴찍히냐?');
        // $roles = Role::all();
        // if (!$roles) {
        //     aobrt(404);
        // }
        //return view('admin.user.store', compact('roles'));
        return view('admin.user.list');
    }
    // 사용자 등록
    public function regist(Request $request) {
        // // 사용자 등록
        // $user = User::create([
        //     'name'  => $request->name, 
        //     'email' => $request->email, 
        //     'password' => bcrypt($request->password), 
        // ]);
        // // 사용자 권한 추가
        // $user->attachRole($request->role);
        // return view('admin.user.list');
        return '사용자 등록';
    }

    // 사용자 리스트 폼
    public function showUserListForm() {
        $users = User::paginate(10);
        return view('admin.user.list')->with('users', $users);
    }

    // 사용자 정보 상세보기 폼
    public function showUserDetailForm(User $user_id) {
        // 사용자 정보 및 등급(?), 권한도 같이 조회해서 넘겨주기.
        dump($user_id);
        $user = User::find($user_id)->first();
        $roles = Role::all();
        // 사용자 roles 테이블 정보.
        
        //dump($user->roles);
        return view('admin.user.detail', compact(['user', 'roles']));
    }

    // 사용자 정보 수정
    // users, role,...
    public function updateUser(Request $request) {
        // 기존 권한 제거 및 데이터 수정
        $user = User::find($request->id);        
        $user->detachRoles($user->roles);
        $user->email = $user->email;
        $user->save();
        
        // 다시 권한 추가
        $user->attachRole($request->role);

        return redirect()->route('admin.user.list');
    }
}
