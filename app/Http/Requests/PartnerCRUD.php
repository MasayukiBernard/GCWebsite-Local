<?php

namespace App\Http\Requests;

use App\Rules\FloatBetween;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PartnerCRUD extends FormRequest
{
    private $inRule;

    public function __construct()
    {
        $this->inRule = 'in:';
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
            'major' => ['required', 'integer', 'exists:majors,id'],
            'uni-name' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:30'],
            'details' => ['required', 'string', 'max:100'],
            'min-gpa' => ['required', new FloatBetween(0, 4, 'min-gpa')],
            'eng-proficiency' => ['required', 'string', 'max:30']
        ];
    }
    
    public function attributes()
    {
        return [
            'major' => 'major name',
            'name' => 'university name',
            'short-detail' => 'short details',
            'min-gpa' => 'minimum gpa',
            'eng-proficiency' => 'english proficiency requirements'
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
            'min-gpa' => 'The minimum gpa must be in the range of 0.00 to 4.00'
        ];
    }
}
