<?php

namespace App\Http\Requests;

use App\Rules\AcademicYearRecordExisted;
use App\Rules\FloatBetween;
use Illuminate\Foundation\Http\FormRequest;

class AcademicYearCRUD extends FormRequest
{

    public function __construct()
    {
    }

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
            'existed' => ['required', new AcademicYearRecordExisted(request()->input('start-year'), request()->input('end-year'), request()->input('smt-type'))],
            'start-year' => ['required', 'date_format:Y'],
            'end-year' => ['required', 'date_format:Y'],
            'smt-type' => ['required', 'integer', 'min:0', 'max:1'],    
        ];
    }
    
    public function attributes()
    {
        return [
            'smt-type' => 'semester type',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $invalid = 'Form is invalid!!';
        return [
            'existed.required' => $invalid,
            'start-year.date_format' => 'The starting year must match the year format \'yyyy\'!!',
            'end-year.date_format' => 'The ending year must match the year format \'yyyy\'!!',
            'smt-type.integer' => $invalid,
            'smt-type.min' => $invalid,
            'smt-type.max' => $invalid,
        ];
    }
}
