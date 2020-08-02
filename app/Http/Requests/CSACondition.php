<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CSACondition extends FormRequest
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
            'med-condition' => ['required', 'string', 'max:1', 'in:0,1'],
            'allergy' => ['required', 'string', 'max:1', 'in:0,1'],
            'special-diet' => ['required', 'string', 'max:1', 'in:0,1'],
            'convicted-crime' => ['required', 'string', 'max:1', 'in:0,1'],
            'future-diffs' => ['required', 'string', 'max:1', 'in:0,1'],
            'explanation' => ['required_if:med-condition,1', 'required_if:allergy,1', 'required_if:special-diet,1', 'required_if:convicted-crime,1', 'required_if:future-diffs,1', 'nullable', 'string', 'max:65535']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $notif = 'Please pick the option from the provided buttons!';

        return [
            'med-condition.in' => $notif,
            'allergy.in' => $notif,
            'special-diet.in' => $notif,
            'convicted-crime.in' => $notif,
            'future-diffs.in' => $notif,
            'explanation.required_if' => 'All above option must all be no to skip the explanation field!' 
        ];
    }
}
