<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FloatBetween implements Rule
{
    private $firstOperand;
    private $secondOperand;
    private $referredField;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($firstOperand, $secondOperand, $referredField)
    {
        $this->firstOperand = $firstOperand;
        $this->secondOperand = $secondOperand;
        $this->referredField = $referredField;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $input = request()->input($this->referredField);
        return ($input >= $this->firstOperand && $input <= $this->secondOperand);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field must be between ' . $this->firstOperand . ' and ' . $this->secondOperand . '.';
    }
}
