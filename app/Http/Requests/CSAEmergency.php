<?php

namespace App\Http\Requests;

use App\CSA_Form;
use Illuminate\Foundation\Http\FormRequest;

class CSAEmergency extends FormRequest
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
            'gender' => ['required', 'string', 'max:1', 'in:M,F'],
            'name' => ['required', 'string', 'max:75'],
            'relationship' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:200'],
            'mobile' => ['required', 'regex:/^[1-9]{1}[0-9]{1,12}$/'],
            'telp-num' => ['required', 'regex:/^[1-9]{1}[0-9]{1,12}$/'],
            'email' => ['required', 'email', 'max:50']
        ];
    }
    
    public function attributes()
    {
        return [
            'mobile' => 'mobile phone number',
            'telp-num' => 'telephone number'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gender.in' => 'Please pick the salutation option from the provided buttons',
            'mobile' => 'The :attribute field is not a valid mobile phone number',
            'telp-num' => 'The :attribute field is not a valid telephone number'
        ];
    }
}
