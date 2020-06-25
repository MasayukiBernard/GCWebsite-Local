<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MajorCRUD extends FormRequest
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
            'major-name' => ['required', 'string', 'max:50'],
        ];
    }
    
    public function attributes()
    {
        return [
            'major-name' => 'major name',
        ];
    }
}
