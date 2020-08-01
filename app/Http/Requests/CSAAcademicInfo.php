<?php

namespace App\Http\Requests;

use App\CSA_Form;
use Illuminate\Foundation\Http\FormRequest;

class CSAAcademicInfo extends FormRequest
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
            'campus' => ['required', 'string', 'max:1', 'in:0,1'],
            'study-level' => ['required', 'string', 'max:1', 'in:U,G'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'gpa' => ['required', 'numeric', 'between:0.00,4.00'],
            'gpa-proof' => [($csa_form->academic_info != null ? '': 'required'), 'mimes:jpeg,png,jpg', 'max:2048'],
            'test-type' => ['string', 'max:1', 'in:0,1'],
            'other-test' => ['required_without:test-type'],
            'score' => ['required', 'numeric'],
            'test-date' => ['required', 'date'],
            'proof-path' => [($csa_form->english_test != null ? '' : 'required'), 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    
    public function attributes()
    {
        return [
            'study-level' => 'level of study',
            'gpa-proof' => 'GPA proof',
            'test-type' => 'English test type',
            'test-date' => 'English test date',
            'proof-path' => 'English test proof'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $campus = 'Please pick the campus field from the provided buttons!';
        $study = 'Please pick the level of study field from the provided buttons!';
        $test_type = 'Please pick the English test type field from the provided buttons or textbox!';

        return [
            'campus.in' => $campus,
            'campus.max' => $campus,
            'test-type.in' => $test_type,
            'test-type.max' => $test_type,
            'study-level.in' => $study,
            'study-level.max' => $study,
            'other-test.required_without' => 'Other English test type is required when any of default ones is not checked!'
        ];
    }
}
