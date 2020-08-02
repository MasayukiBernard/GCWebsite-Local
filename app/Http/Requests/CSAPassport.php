<?php

namespace App\Http\Requests;

use App\CSA_Form;
use Illuminate\Foundation\Http\FormRequest;

class CSAPassport extends FormRequest
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
        $csa_form = CSA_Form::where('id', session('csa_form_id'))->first();

        return [
            'pass-num' => ['required', 'string', 'max:9'],
            'pass-expiry' => ['required', 'max:10', 'date'],
            'pass-proof-path' => [($csa_form->passport != null ? '' : 'required'), 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    
    public function attributes()
    {
        return [
           'pass-num' => 'passport number',
           'pass-expiry' => 'passport expiration date',
           'pass-proof-path' => 'passport proof'
        ];
    }
}
