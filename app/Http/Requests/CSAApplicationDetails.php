<?php

namespace App\Http\Requests;

use App\Rules\YearlyPartnerExist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CSAApplicationDetails extends FormRequest
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
        $keys = array('preferred-uni', 'motivation');
        $values = array(
            array('nullable', 'integer'),
            array('nullable', 'string', 'max:65535')
        );

        for($i = 0; $i < 3; ++$i){
            for($j = 0; $j < 2; ++$j){
                $val_array = array();
                $req_with = '';
                for($k = 0; $k < 2; ++$k){
                    if($k == $j){
                        continue;
                    }
                    $req_with = $req_with . $keys[$k] . '-' . $i . ',';
                }
                array_push($val_array, 'required_with:' . Str::beforeLast($req_with, ','));
                $val_pairs = array_merge($val_array, $values[$j]);
                
                if($j == 0){
                    for($l = 0; $l < 3; ++$l){
                        if($l == $i){
                            continue;
                        }
                        array_push($val_pairs, 'different:preferred-uni-' . $l);
                    }
                    array_push($val_pairs, new YearlyPartnerExist($keys[0] . '-' . $i));
                }
                $rule_array[$keys[$j] . '-' . $i] = $val_pairs;
            }
        }

        return $rule_array;
    }
    
    public function attributes()
    {
        $val_pairs = array();
        $keys = array('preferred-uni', 'motivation');
        $orders = array('first', 'second', 'third');
        $attributes = array('preferred partner university', 'motivation');
        for($i = 0; $i < 3; ++$i){
            for($j = 0; $j < 2; ++$j){
                $val_pairs[$keys[$j] . '-' . $i]  = $orders[$i] . ' ' . $attributes[$j];
            }
        }

        return $val_pairs;
    }
}
