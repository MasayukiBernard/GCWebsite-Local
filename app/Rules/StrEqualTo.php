<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

// A rule to check whether the given string is equal to another string
class StrEqualTo implements Rule{

    private $referredField = null;
    private $referredFieldCustomName = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $referredField, string $referredFieldCustomName){
        $this->referredField = $referredField;
        $this->referredFieldCustomName = $referredFieldCustomName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        return request()->input($this->referredField) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(){
        return 'The :attribute field must match with ' . $this->referredFieldCustomName . ' field.';
    }
}
