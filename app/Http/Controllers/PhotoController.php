<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Yearly_Student;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
Use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     *   Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $path
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {
        $actual_path = null;
        $user = Auth::user();

        if($user->is_staff){
            /*
                url format = /photos/{table}_id={id}&opt={column}
            */
            $table  = Str::before($path, '_id');
            $id     = Str::between($path, 'id=', '&');
            $column = Str::after($path, 'opt=');

            $id_col_name = array(
                'students' => 'user_id',
                'achievements'  => 'id', 
                'english_tests'  => 'csa_form_id',
                'academic_infos'  => 'csa_form_id',
                'passports'  => 'csa_form_id'
            );
    
            if($table === 'users'){
                $table = 'students';
            }
    
            if(Arr::exists($id_col_name, $table) && DB::table($table)->where($id_col_name[$table], $id)->first() != null){
                $actual_path = DB::table($table)->select($column)->where($id_col_name[$table], $id)->first()->$column;
            }
    
            if($actual_path != null){
                if(Storage::disk('private')->exists($actual_path)){
                    return response()->file(storage_path('app\private\\' . $actual_path));
                }
            }
            abort(404);
        }
        else if(!($user->is_staff)){
            // Temporary Images
            /*
                url format = /photos/type=temp&opt={requested_image}
                // Check about image caching, this still works on Firefox
             */
            if(preg_match('/^type=temp&opt=(profile\-picture|id\-card|flazz\-card)$/', $path) == 1){
                $requested_image = Str::after($path, '&opt=');
                $sess_data = session('student_temp_pictures_path');
                $sess_array = array(
                    'profile-picture' => 'pp',
                    'id-card' => 'ic',
                    'flazz-card' => 'fc'
                );

                if(Storage::disk('private')->exists($sess_data[$sess_array[$requested_image]])){
                    return response()->file(storage_path('app\private\\' . $sess_data[$sess_array[$requested_image]]));
                }
            }
            // Saved Images
            /*
                url format = /photos/ys={yearly_student_id}&opt={requested_image}&id={optional_id?}
                // Work on image caching
             */
            else if(preg_match('/^ys=[0-9]+&opt=(profile\-picture|id\-card|flazz\-card|passport|gpa\-transcript\-proof|english\-test\-result|achievement\-proof(&id=[0-9]+))$/', $path) == 1){
                $yearly_student_id = Str::between($path, 'ys=', '&opt=');
                $yearly_student = Yearly_Student::where('id', $yearly_student_id)->first(); 
                $requested_image = Str::between($path, 'opt=', '&id=');
                $optional_id     = 0;
                $csa_form_id = 0;

                $referred_tables = array(
                    'profile-picture' => 'students',
                    'id-card'  => 'students', 
                    'flazz-card'  => 'students',
                    'passport'  => 'passports',
                    'gpa-transcript-proof' => 'academic_infos',
                    'english-test-result'  => 'english_tests',
                    'achievement-proof' => 'achievements'
                );

                $id_col_name = array(
                    'students' => 'nim',
                    'achievements'  => 'id', 
                    'english_tests'  => 'csa_form_id',
                    'academic_infos'  => 'csa_form_id',
                    'passports'  => 'csa_form_id'
                );

                $requested_image_paths = array(
                    'profile-picture' => 'picture',
                    'id-card'  => 'id_card_picture', 
                    'flazz-card'  => 'flazz_card_picture',
                    'passport'  => 'pass_proof',
                    'gpa-transcript-proof' => 'gpa_proof',
                    'english-test-result'  => 'proof',
                    'achievement-proof' => 'proof'
                );

                if($yearly_student_id != 0){
                    if($yearly_student == null || strcmp($yearly_student->student->nim, $user->student->nim) != 0){
                        abort(403);
                    }
                    if(!(in_array($requested_image, ['passport', 'gpa-transcript-proof', 'english-test-result', 'achievement-proof']))){
                        abort(404);
                    }

                    $yearly_csa_form = $yearly_student->csa_form;
                    if($yearly_csa_form != null){
                        $csa_form_id = $yearly_csa_form->id;
                    }
                }
                else if($yearly_student_id == 0){
                    if(!(in_array($requested_image, ['profile-picture', 'id-card', 'flazz-card']))){
                        abort(404);
                    }
                }

                $temp_id = Str::after($path, '&id=');
                if(strcmp($temp_id, $path) != 0){
                    $optional_id = $temp_id;
                }

                $col_values = array(
                    'students' => $yearly_student_id == 0 ? $user->student->nim : $yearly_student->student->nim,
                    'achievements'  => $optional_id, 
                    'english_tests'  => $csa_form_id,
                    'academic_infos'  => $csa_form_id,
                    'passports'  => $csa_form_id
                );

                $achievement = DB::table('achievements')->select('csa_form_id')->where('id', $optional_id)->first();
                if($referred_tables[$requested_image] == 'achievements' && ($optional_id == 0 || $achievement == null)){
                    abort(404);
                }

                if($achievement != null){
                    if($achievement->csa_form_id != $csa_form_id){
                        abort(404);
                    }
                }

                if(Arr::exists($requested_image_paths, $requested_image)){
                    $table = $referred_tables[$requested_image];
                    $field = $requested_image_paths[$requested_image] . '_path';
                    $actual_path = DB::table($referred_tables[$requested_image])
                                ->select($field)
                                ->where($id_col_name[$table], $col_values[$table])
                                ->first();
                    if($actual_path != null){
                        if(Storage::disk('private')->exists($actual_path->$field)){
                            return response()->file(storage_path('app\private\\' . $actual_path->$field));
                        }
                    }
                }
            }
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
