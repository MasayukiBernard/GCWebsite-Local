<?php

namespace App\Http\Requests;

use App\Achievement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CSAAchievement extends FormRequest
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
        $rule_array = array();
        $keys = array('name', 'year', 'institution', 'other-details', 'proof-path');
        $values = array(
            array('nullable', 'string', 'max:100'),
            array('nullable', 'integer', 'between:0,9999'),
            array('nullable', 'string', 'max:50'),
            array('nullable', 'string', 'max:100'),
            array('nullable', 'mimes:jpeg,png,jpg', 'max:2048') 
        );

        $achievements = Achievement::where('csa_form_id', session('csa_form_id'))->orderBy('latest_created_at')->get();

        for($i = 0; $i < 3; ++$i){
            for($j = 0; $j < 5; ++$j){
                $val_array = array();
                $req_with = '';
                for($k = 0; $k < 5; ++$k){
                    if($k == $j){
                        continue;
                    }
                    if(isset($achievements[$i]) && $k == 4){
                        continue;
                    }
                    $req_with = $req_with . $keys[$k] . '-' . $i . ',';
                }

                if(isset($achievements[$i]) && $j == 4){
                    $rule_array[$keys[$j] . '-' . $i] = $values[$j];
                    continue;
                }
                array_push($val_array, 'required_with:' . Str::beforeLast($req_with, ','));
                $val_pairs = array_merge($val_array, $values[$j]);
                $rule_array[$keys[$j] . '-' . $i] = $val_pairs;
            }
        }

        return $rule_array;
    }
    
    public function attributes()
    {
        $val_pairs = array();
        $keys = array('name', 'year', 'institution', 'other-details', 'proof-path');
        $orders = array('first', 'second', 'third');
        $attributes = array('achievement name', 'year', 'institituion issuer', 'details', 'proof');
        for($i = 0; $i < 3; ++$i){
            for($j = 0; $j < 5; ++$j){
                $val_pairs[$keys[$j] . '-' . $i]  = $orders[$i] . ' ' . $attributes[$j];
            }
        }

        return $val_pairs;
    }
}
