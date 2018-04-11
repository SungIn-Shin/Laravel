<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();   
        if($user->hasRole('admin')) {
            return true;
        } else {
            return false;
        } 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'email' => 'required|email|unique:users|max:255', 
            'name'  => 'required|string|max:255',
            // 영어 대.소문자, 숫자, 특수문자를 모두 조합한 8자리 이상 30자리 이하 비밀번호 입력.
            'password' => 'required|confirmed|min:8|max:30|regex:/^.*(?=^.{8,30}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*+=]).*$/',
            'team' => 'required', 
            'position' => 'required', 
            'role' => 'required',
            'otpkey' => 'nullable|min:16|max:16', // 2018.04.09 KKW
        ];
    }
}
