<?php

namespace App\Http\Requests;

use App\Rules\EmailNotExist;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StudentProfileEdit extends FormRequest
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
        $student = Auth::user()->student;
        
        return [
            'profile-picture' => [($student->picture_path == '-' ? 'required' : ''), 'mimes:jpeg,png,jpg', 'max:2048'],
            'id-card' => [($student->id_card_picture_path == '-' ? 'required' : ''), 'mimes:jpeg,png,jpg', 'max:2048'],
            'flazz-card' => [($student->flazz_card_picture_path == '-' ? 'required' : ''), 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'max:75', 'regex:/^[a-zA-Z0-9]{1}[a-zA-Z0-9\s]{1,73}[a-zA-Z0-9]{1}$/'],
            'gender' => ['required', 'string', 'max:1', 'in:M,F'],
            'email' => ['required', 'email', 'max:50', new EmailNotExist('email')],
            'mobile' => ['required', 'regex:/^[1-9]{1}[0-9]{1,12}$/'],
            'telp-num' => ['required', 'regex:/^[1-9]{1}[0-9]{1,12}$/'],
            'major' => ['required', 'exists:majors,id'],
            'place-birth' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9]{1}[a-zA-Z0-9\s]{1,73}[a-zA-Z0-9]{1}$/'],
            'date-birth' => ['required', 'string', 'size:10', 'date'],
            'nationality' => ['required', 'string', 'alpha', 'max:20'],
            'address' => ['required', 'string', 'max:200']
        ];
    }
    
    public function attributes()
    {
        return [
            'profile-picture' => 'profile picture file',
            'id-card' => 'ID card picture file',
            'flazz-card' => 'Flazz card picture file',
            'mobile' => 'mobile phone number',
            'telp-num' => 'telephone number',
            'major' => 'enrolled major',
            'place-birth' => 'place of birth',
            'date-birth' => 'date of birth',
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
            'name.regex' => 'The :attribute field can only be alphabets, numbers, and it cannot begin or end with with space character.',
            'gender.max' => 'Please input the gender field selection with only the provided buttons!',
            'gender.in' => 'Please input the gender field selection with only the provided buttons!',
            'mobile.regex' => 'The :attribute field can only be filled with appropriate numbers!',
            'telp-num.regex' => 'The :attribute field can only be filled with appropriate numbers!',
            'place-birth.regex' => 'The :attribute field can only be alphabets, numbers, and it cannot begin or end with with space character.',
            'major.exists' => 'Please input the major field only with the options provided in the selection!',
        ];
    }
}
