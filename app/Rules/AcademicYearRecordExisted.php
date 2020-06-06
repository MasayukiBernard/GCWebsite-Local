<?php

namespace App\Rules;

use App\Academic_Year;
use Illuminate\Contracts\Validation\Rule;

// A rule to prevent the same record in "academic_years" table
class AcademicYearRecordExisted implements Rule{

    private $starting_year = null;
    private $ending_year = null;
    private $odd_semester = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($starting_year, $ending_year, $odd_semester){
        $this->starting_year = $starting_year;
        $this->ending_year = $ending_year;
        $this->odd_semester = $odd_semester;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $existingRecord = Academic_Year::where([
            ['starting_year', '=', $this->starting_year],
            ['ending_year', '=', $this->ending_year],
            ['odd_semester', '=', $this->odd_semester]
        ])->first();

        return ($existingRecord == null);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(){
        return 'The inputted academic year \'' . $this->starting_year . '/' . $this->ending_year . ' - '. ($this->odd_semester ? 'Odd' : 'Even') .'\' has already existed!!';
    }
}
