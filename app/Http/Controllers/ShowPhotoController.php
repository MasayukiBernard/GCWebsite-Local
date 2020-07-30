<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ShowPhotoController extends Controller
{
    private $title = array(
        'students' => 'Profile Photo',
        'achievements'  => 'Achievements Proof', 
        'english_tests'  => 'English Test Result Proof',
        'academic_infos'  => 'GPA Transcript Proof',
        'passports'  => 'Passport Proof'
    );

    private $requested_image_list = array(
        'profile-picture' => 'Profile Picture',
        'id-card'  => 'ID Card Picture', 
        'flazz-card'  => 'Binusian Flazz Card',
        'passport'  => 'Passport Proof',
        'gpa-transcript-proof' => 'GPA Transcript Proof',
        'english-test-result'  => 'English Test Result Proof',
        'achievement-proof' => 'Achievement Proof'
    );
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show_staff($last_modified, $table_name, $id, $column_name)
    {
        if(!(Arr::exists($this->title, $table_name))){
            abort(404);
        }

        return view('see-img', [
            'is_staff' => Auth::user()->is_staff,
            'title' => 'Student\'s ' . $this->title[$table_name],
            'table' => $table_name,
            'id' => $id,
            'column' => $column_name,
            'last_modified' => $last_modified
        ]);
    }

    public function show_student($last_modified, $yearly_student_id, $requested_image, $optional_id = null){
        if(!(Arr::exists($this->requested_image_list, $requested_image))){
            abort(404);
        }

        return view('see-img', [
            'is_staff' => Auth::user()->is_staff,
            'title' => 'Student\'s ' . $this->requested_image_list[$requested_image],
            'id' => $yearly_student_id,
            'req' => $requested_image,
            'opt_id' => ($optional_id != null ? '&id=' . $optional_id : ''),
            'last_modified' => $last_modified
        ]);
    }
}