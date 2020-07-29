<?php

namespace App\Http\Requests;

use App\Rules\StrEqualTo;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
{
    public function authorize(){
        // this MUST return true, authorization logic of the request is done using middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Refer to change-pass blade file for the regex explanation
        return [
            'new-pass' => ['required', 'string', 'min:8', 'max:100', 'regex:/\\A[a-zA-Z0-9`~!@#\\$%\\^&\\*\\(\\)_\\-\\+=\\[\\{\\]\\}\\\\\\|;:\\\'",<\\.>\\/\\?]+\\z/'],
            'confirm-new-pass' => ['required', 'string', 'max:100', new StrEqualTo('new-pass', 'New Password')]
        ];
    }
    
    public function attributes()
    {
        return [
            'new-pass' => 'new password',
            'confirm-new-pass' => 'confirm new password'
        ];
    }
}
