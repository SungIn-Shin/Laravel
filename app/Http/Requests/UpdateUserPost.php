<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class UpdateUserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // $user = Auth::user();   
        // if($user->hasRole('admin')) {
        //     return true;
        // } else {
        //     return false;
        // } 
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
            'email' => 'required', 
            'name'  => 'required|string|max:255',
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|max:30'/*|regex:/^.*(?=^.{8,30}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*+=]).*$/'*/, 
            'team' => 'required', 
            'position' => 'required'
        ];
    }
}
