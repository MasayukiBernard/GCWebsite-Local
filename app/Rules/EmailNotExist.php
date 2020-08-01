<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class EmailNotExist implements Rule
{
    private $arg;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($arg)
    {
        $this->$arg = $arg;
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
        return User::where('is_staff', false)->where('email', request('email'))->first() == null ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute you have entered has already been used, please enter another one!';
    }
}
