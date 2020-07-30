<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

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
        $major = DB::table('majors')
                    ->select('name')
                    ->where('latest_deleted_at', null)->where('name', request('major-name'))
                    ->first();
        $name = " ";
        if($major != null){
            $name = $major->name;
        }

        return [
            'major-name' => ['required', 'string', 'max:50', 'not_in:'. $name],
        ];
    }
    
    public function attributes()
    {
        return [
            'major-name' => 'major name',
        ];
    }

    public function messages(){
        return[
            'major-name.not_in' => 'Major name has already existed!'
        ];
    }
}
