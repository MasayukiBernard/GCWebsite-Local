<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class ShowPhotoController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function __invoke($table_name, $id, $column_name)
    {
        $title = array(
            'students' => 'Student\'s Profile Photo',
            'achievements'  => 'Student\'s Achievements Proof', 
            'english_tests'  => 'Student\'s English Test Result Proof',
            'academic_infos'  => 'Student\'s GPA Transcript Proof',
            'passports'  => 'Student\'s Passport Proof'
        );

        return view('staff_side\see-img', [
            'title' => $title[$table_name],
            'table' => $table_name,
            'id' => $id,
            'column' => $column_name,
        ]);
    }
}