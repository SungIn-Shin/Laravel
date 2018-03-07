<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllimtalkFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'call_from' => array( 'required', 
                                  'regex:/^\d{3}-\d{3,4}-\d{4}$/', 
                                  'max:13'),
            'call_to'   => array( 'required', 
                                  'regex:/^\d{3}-\d{3,4}-\d{4}$/', 
                                  'max:13'),            
            'sms_txt'   => 'required',
        ];
    }  
}
