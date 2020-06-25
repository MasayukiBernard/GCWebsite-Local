<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    // if user accessed any route that is not listed below
    return response()
    ->view('warnings.lost', [], 404);
});

// Auth route, with register feature turned off
Auth::routes(['register' => false]);

// Routes that can be accessed only by
// -> Authenticated users
Route::middleware('auth')->group(function(){
    Route::get('/test', function(){
    });
    // -> Staff Users
    Route::middleware('staff')->group(function(){

        Route::resource('photos', 'Staff\PhotoController');

        Route::name('staff.')->group(function(){
            Route::prefix('staff')->group(function(){
                Route::prefix('home')->group(function(){
                    $home_controller = 'HomeController@';
                    Route::get('/', $home_controller . 'staff_index')->name('home');
                    Route::post('/academic-year/{id}', $home_controller . 'get_percentages');
                });
                
                Route::name('academic-year.')->group(function(){
                    Route::prefix('academic-year')->group(function(){
                        $year_controller = "Staff\ManageAcademicYearController@";

                        Route::get('/', $year_controller . 'show_academicYearPage')->name('page');
                        Route::get('/create', $year_controller . 'show_createPage')->name('create-page');
                        Route::post('/create/confirm', $year_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/academic-year', $year_controller . 'create')->name('create');

                        Route::post('/delete/confirm/{academic_year_id}', $year_controller . 'confirm_delete');
                        Route::post('/delete/academic-year', $year_controller . 'delete')->name('delete');
                    });
                });

                Route::name('major.')->group(function(){
                    Route::prefix('major')->group(function(){
                        $major_controller = 'Staff\ManageMajorController@';

                        Route::get('/', $major_controller . 'show_majorPage')->name('page');
                        Route::get('/create', $major_controller . 'show_createPage')->name('create-page');
                        Route::post('/create/master-major', $major_controller . 'create')->name('create');
                        Route::get('/edit/{major}' , $major_controller . 'show_editPage')->name('edit-page');
                        Route::post('/update/master-major', $major_controller . 'update')->name('update');
                        Route::get('/delete/{id}', $major_controller . 'delete')->name('delete');

                    });
                });

                Route::name('partner.')->group(function(){
                    Route::prefix('partner')->group(function(){
                        $partner_controller = 'Staff\ManagePartnerController@';

                        Route::get('/', $partner_controller . 'show_partnerPage')->name('page');
                        Route::post('/major/{id}', $partner_controller . 'show_major_partners');
    
                        Route::get('/create', $partner_controller . 'show_createPage')->name('create-page');
                        Route::post('/create/confirm', $partner_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/master-partner', $partner_controller . 'create')->name('create');
    
                        Route::get('/details/{partner}', $partner_controller . 'show_partner_details');
                        Route::get('/edit/{partner}', $partner_controller . 'show_editPage')->name('edit-page');
                        Route::post('/update/confirm', $partner_controller . 'confirm_update')->name('update-confirm');
                        Route::post('/update/master-partner', $partner_controller . 'update')->name('update');
                        Route::post('/delete/master-partner/', $partner_controller . 'delete')->name('delete');
                    });
                });

                Route::name('yearly-partner.')->group(function(){
                    Route::prefix('yearly-partner')->group(function(){
                        $yPartner_controller = 'Staff\ManageYearlyPartnerController@';
                        Route::get('/', $yPartner_controller . 'show_yearlyPartnerPage')->name('page');

                        Route::get('/create', $yPartner_controller . 'show_createPage')->name('create-page');
                        Route::post('/academic-year/{id}/partners', $yPartner_controller . 'show_unpicked_partners');
                        Route::post('/create/confirm', $yPartner_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/yearly-partner', $yPartner_controller . 'create')->name('create');

                        Route::get('/list/{academic_year_id}', $yPartner_controller . 'show_yearlyPartnerDetails')->name('details');
                        Route::post('/delete/confirm/{yearly_partner_id}', $yPartner_controller . 'confirm_delete');
                        Route::post('/delete/yearly-partner/', $yPartner_controller . 'delete')->name('delete');
                    });
                });

                Route::name('student.')->group(function(){
                    Route::prefix('student')->group(function(){
                        $student_controller = 'Staff\ManageStudentController@';
                        Route::get('/', $student_controller . 'show_studentPage')->name('page');
                        Route::post('/binusian-year/{year}', $student_controller . 'show_StudentsByYear');
                        
                        Route::get('/create', $student_controller . 'show_createPage')->name('create-page');
                        Route::post('/download/batch-template', $student_controller . 'download_template')->name('download-batch-template');
                        Route::get('/create/single', $student_controller . 'show_createSinglePage')->name('create-page-single');
                        Route::post('/create/single/confirm', $student_controller . 'confirm_create_single')->name('create-single-confirm');
                        Route::post('/create/single/student', $student_controller . 'create_single')->name('create-single');

                        Route::get('/create/batch', $student_controller . 'show_createBatchPage')->name('create-page-batch');
                        Route::post('/create/batch/confirm', $student_controller . 'confirm_create_batch')->name('create-batch-confirm');
                        Route::post('/create/batch/student', $student_controller . 'create_batch')->name('create-batch');

                        Route::get('/details/{user}', $student_controller . 'show_studentDetails');

                        Route::post('/delete/student', $student_controller . 'delete')->name('delete');
                    });
                });

                Route::name('yearly-student.')->group(function(){
                    Route::prefix('yearly-student')->group(function(){
                        $yStudent_controller = 'Staff\ManageYearlyStudentController@';
                        Route::get('/', $yStudent_controller . 'show_yearlyStudentPage')->name('page');
                        
                        Route::get('/create', $yStudent_controller . 'show_createPage')->name('create-page');
                        Route::post('/academic-year/{id}/students/{year}', $yStudent_controller . 'show_unpicked_students');
                        Route::post('/create/confirm', $yStudent_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/yearly-student', $yStudent_controller . 'create')->name('create');

                        Route::get('/list/{academic_year_id}', $yStudent_controller . 'show_yearlyStudentDetails')->name('details');
                        Route::get('/csa-forms/{yearly_student_id}', $yStudent_controller . 'show_csaFormsPage');

                        Route::post('/delete/confirm/{yearly_student_id}', $yStudent_controller . 'confirm_delete');
                        Route::post('/delete/yearly-partner', $yStudent_controller . 'delete')->name('delete');
                    });
                });

                Route::name('csa-forms.')->group(function(){
                    Route::prefix('csa-forms')->group(function(){
                        $csa_form_controller = 'Staff\ManageCSAFormController@';

                        Route::get('/', $csa_form_controller . 'show_page')->name('page');
                        Route::get('/academic-year/{academic_year_id}/major/{major_id}', $csa_form_controller . 'get_CSAForms');

                        Route::get('/details/{csa_form_id}', $csa_form_controller . 'show_detailsPage')->name('details');
                        Route::post('/{csa_form_id}/choice/{choice_id}/confirm-nomination', $csa_form_controller . 'confirm_nomination');
                        Route::post('/nominate/csa_forms', $csa_form_controller . 'nominate')->name('nominate');
                        Route::post('/{csa_form_id}/cancel-nomination', $csa_form_controller . 'cancel_nomination')->name('cancel-nomination');
                    });
                });

                Route::prefix('profile')->group(function(){
                    $profile_controller = 'ManageProfileController@';
                    Route::get('/', $profile_controller . 'show_staffProfile')->name('profile');
                    Route::get('change-pass', $profile_controller . 'show_changePass')->middleware('password.confirm')->name('change-pass-view');;
                });
            });
        });
    });
    // -> Student Users
    Route::middleware('student')->group(function(){
        Route::name('student.')->group(function(){
            Route::prefix('student')->group(function(){
                Route::get('home', 'HomeController@student_index')->name('home');
                Route::prefix('profile')->group(function(){
                    $profile_controller = 'User\ManageProfileController@';
                    Route::get('/', $profile_controller . 'show_studentProfile')->name('profile');
                    Route::get('change-pass', $profile_controller . 'show_changePass')->middleware('password.confirm')->name('change-pass-view');
                });
                Route::prefix('csaform')->group(function(){
                    Route::get('/', 'User\ManageCSAFormController@show_csaFormPage')->name('csaform');
                });
            });
        });
    });
    // -> Both
    Route::post('/password/change', 'ManageProfileController@handle_ChangePass')
        ->middleware('changePass')->name('change-pass');
});
