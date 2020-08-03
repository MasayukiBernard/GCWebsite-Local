<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
})->middleware('throttle:120,1');

Route::fallback(function () {
    // if user accessed any route that is not listed below
    return response()
    ->view('warnings.lost', [], 404);
})->middleware('throttle:30,1');

// Auth route, with register feature turned off and default account email verification
Auth::routes(['register' => false, 'verify' => true]);

// Routes that can be accessed only by
// -> Authenticated users
Route::middleware('auth', 'throttle:150,15')->group(function(){
    Route::get('/test', function(){
        
    });

    // Prevent this route to be accessed directly from GET requests
    Route::resource('photos', 'PhotoController');

    // -> Staff Users
    Route::middleware('staff', 'verified')->group(function(){
        Route::name('staff.')->group(function(){
            Route::get('/image/{last_modified}/{table_name}/{id}/{column_name}', 'ShowPhotoController@show_staff')->name('see-image');
            Route::prefix('staff')->group(function(){
                Route::prefix('home')->group(function(){
                    $home_controller = 'HomeController@';
                    Route::get('/', $home_controller . 'staff_index')->name('home');
                    Route::post('/major/{major_id}/academic-year/{academic_year_id}', $home_controller . 'get_percentages');
                });
                
                Route::name('student-request.')->group(function(){
                    Route::prefix('student-request')->group(function(){
                        $student_req_controller = 'Staff\ManageStudentRequestController@';
                        Route::get('/', $student_req_controller . 'show_approvalPage')->name('page');
                        Route::post('/notify/{student_request_id}', $student_req_controller . 'notify_request');
                        Route::post('/deny', $student_req_controller . 'deny_request')->name('deny-request');
                        Route::post('/approve', $student_req_controller . 'approve_request')->name('approve-request');
                    });
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
                        Route::post('/create/confirm', $major_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/master-major', $major_controller . 'create')->name('create');

                        Route::get('/edit/{major}' , $major_controller . 'show_editPage')->name('edit-page');
                        Route::post('/update/confirm', $major_controller . 'confirm_update')->name('update-confirm');
                        Route::post('/update/master-major', $major_controller . 'update')->name('update');

                        Route::post('/delete/confirm/{major_id}', $major_controller . 'confirm_delete');
                        Route::post('/delete/major', $major_controller . 'delete')->name('delete');

                    });
                });

                Route::name('partner.')->group(function(){
                    Route::prefix('partner')->group(function(){
                        $partner_controller = 'Staff\ManagePartnerController@';

                        Route::get('/', $partner_controller . 'show_partnerPage')->name('page');
                        Route::post('/major/{id}/sort-by/{field}/{sort_type}', $partner_controller . 'show_major_partners');
    
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

                        Route::get('/list/{academic_year_id}', $yPartner_controller . 'show_yearlyPartnerDetailsPage')->name('details');
                        Route::post('/list/{academic_year_id}/major/{major_id}/sort-by/{field}/{sort_type}', $yPartner_controller . 'get_yearlyPartnerDetails');

                        Route::post('/delete/confirm/academic-year/{academic_year_id}/partner/{partner_id}', $yPartner_controller . 'confirm_delete');
                        Route::post('/delete/yearly-partner/', $yPartner_controller . 'delete')->name('delete');
                    });
                });

                Route::name('student.')->group(function(){
                    Route::prefix('student')->group(function(){
                        $student_controller = 'Staff\ManageStudentController@';
                        Route::get('/', $student_controller . 'show_studentPage')->name('page');
                        Route::post('/binusian-year/{year}/sort-by/{field}/{sort_type}', $student_controller . 'show_StudentsByYear');
                        
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
                        Route::post('/academic-year/{academic_year_id}/sort-by/{field}/{sort_type}', $yStudent_controller . 'get_sortedStudentDetails');
                        Route::get('/csa-forms/{yearly_student_id}', $yStudent_controller . 'show_csaFormsPage');

                        Route::post('/delete/confirm/{yearly_student_id}', $yStudent_controller . 'confirm_delete');
                        Route::post('/delete/yearly-partner', $yStudent_controller . 'delete')->name('delete');
                    });
                });

                Route::name('csa-forms.')->group(function(){
                    Route::prefix('csa-forms')->group(function(){
                        $csa_form_controller = 'Staff\ManageCSAFormController@';

                        Route::get('/', $csa_form_controller . 'show_page')->name('page');
                        Route::get('/academic-year/{academic_year_id}/major/{major_id}', $csa_form_controller . 'show_CSAForms');
                        Route::post('/academic-year/{academic_year_id}/major/{major_id}/sort-by/{field}/{sort_type}', $csa_form_controller . 'get_sortedCSAForms');

                        Route::get('/details/{csa_form_id}', $csa_form_controller . 'show_detailsPage')->name('details');
                        Route::post('/{csa_form_id}/choice/{choice_id}/confirm-nomination', $csa_form_controller . 'confirm_nomination');
                        Route::post('/nominate/csa_forms', $csa_form_controller . 'nominate')->name('nominate');
                        Route::post('/{csa_form_id}/cancel-nomination', $csa_form_controller . 'cancel_nomination')->name('cancel-nomination');
                    });
                });

                Route::prefix('profile')->group(function(){
                    $profile_controller = 'ManageProfileController@';
                    Route::get('/', $profile_controller . 'show_staffProfile')->name('profile');

                    Route::get('/change-pass', $profile_controller . 'show_changePass')->middleware('password.confirm')->name('change-pass-page');

                    Route::get('/edit', $profile_controller . 'show_staffEditPage')->name('profile-edit-page');
                    Route::post('/edit/confirm', $profile_controller . 'confirm_staffEdit')->name('profile-edit-confirm');
                    Route::post('/edit/user', $profile_controller . 'update_staff')->name('profile-edit');
                });
            });
        });
    });

    // -> Student Users
    Route::middleware('student')->group(function(){
        Route::name('student.')->group(function(){
            Route::prefix('student')->group(function(){
                Route::middleware('profile-updated', 'verified', 'profile-finalized')->group(function(){
                    Route::get('/{last_modified}/{yearly_student_id}/image/{requested_image}/{optional_id?}', 'ShowPhotoController@show_student')->name('see-image');
                    
                    Route::get('home', 'HomeController@student_index')->name('home');

                    $yearly_partner_controller = 'Student\YearlyPartnerController@';

                    Route::get('/yearly-partners/pick-year', $yearly_partner_controller . 'show_initialView')->name('pick-year');
                    Route::get('/academic-year/{academic_year_id}/yearly-partners', $yearly_partner_controller . 'show_page')->name('yearly-partners');

                    Route::name('csa-form.')->group(function(){
                        Route::prefix('csa-form')->group(function(){
                            $csa_controller = 'Student\ManageCSAFormController@';
                            Route::get('/', $csa_controller . 'show_initialView')->name('csa-mainpage');
                            Route::post('/ys-id', $csa_controller . 'set_ysid_session')->name('set-ysid');

                            Route::middleware('csa-form-none')->group(function(){
                                $csa_controller = 'Student\ManageCSAFormController@';
                                Route::get('/create', $csa_controller . 'show_createPage')->name('create-page');
                                Route::post('/create/csa-form', $csa_controller . 'create')->name('create');
                            });

                            Route::middleware('csa-form-created')->group(function(){
                                $csa_controller = 'Student\ManageCSAFormController@';
                                Route::middleware('csa-form-redirected-summary')->group(function(){
                                    $csa_controller = 'Student\ManageCSAFormController@';
                                    Route::get('/csa-page-1', $csa_controller . 'show_insertPage1')->name('csa-page1');
                                    Route::post('/csa-page-1', $csa_controller . 'goto_page2')->name('after-page1');
                                    Route::get('/csa-page-2', $csa_controller . 'show_insertPage2')->name('csa-page2');
                                    Route::post('/csa-page-2', $csa_controller . 'page2_insert')->name('after-page2');
                                    Route::get('/csa-page-2a', $csa_controller . 'show_insertPage2a')->name('csa-page2a');
                                    Route::post('/csa-page-2a', $csa_controller . 'page2a_insert')->name('after-page2a');
                                    Route::get('/csa-page-3', $csa_controller . 'show_insertPage3')->name('csa-page3');
                                    Route::post('/csa-page-3', $csa_controller . 'page3_insert')->name('after-page3');
                                    Route::get('/csa-page-4', $csa_controller . 'show_insertPage4')->name('csa-page4');
                                    Route::post('/csa-page-4', $csa_controller . 'page4_insert')->name('after-page4');
                                    Route::get('/csa-page-5', $csa_controller . 'show_insertPage5')->name('csa-page5');
                                    Route::post('/csa-page-5', $csa_controller . 'page5_insert')->name('after-page5');
                                    Route::get('/csa-page-6', $csa_controller . 'show_insertPage6')->name('csa-page6');
                                    Route::post('/csa-page-6', $csa_controller . 'page6_insert')->name('after-page6');
                                    Route::get('/csa-page-7', $csa_controller . 'show_insertPage7')->name('csa-page7');
                                    Route::post('/csa-page-7', $csa_controller . 'page7_insert')->name('after-page7');
                                });
                                Route::get('/summary', $csa_controller . 'show_summaryPage')->middleware('csa-form-submitted')->name('summary');
                            });
                        });
                    });
                });

                Route::prefix('profile')->group(function(){
                    $profile_controller = 'ManageProfileController@';
                    Route::get('/', $profile_controller . 'show_studentProfile')->name('profile');
                    Route::middleware('profile-prevent-update')->group(function(){
                        $profile_controller = 'ManageProfileController@';
                        Route::get('/edit', $profile_controller . 'show_studentEditPage')->name('profile-edit-page');
                        Route::post('/edit/confirm', $profile_controller . 'confirm_studentEdit')->name('profile-edit-confirm');
                        Route::post('/edit/user', $profile_controller . 'update_student')->name('profile-edit'); 
                    });

                    Route::post('/finalize', $profile_controller . 'finalize_profile')->name('profile-finalize');

                    Route::middleware('profile-edit-request-none', 'profile-finalized')->group(function(){
                        $profile_controller = 'ManageProfileController@';
                        Route::get('/request-edit', $profile_controller . 'show_requestProfileEditPage')->name('profile-request-edit-page');
                        Route::post('/request-edit/submit', $profile_controller . 'request_profile_edit')->name('profile-request-edit');
                    });

                    Route::get('change-pass', $profile_controller . 'show_changePass')->middleware(['profile-updated', 'password.confirm'])->name('change-pass-page');
                });
            });  
        });
    });
    // -> Both
    Route::post('/password/change', 'ManageProfileController@handle_ChangePass')
        ->middleware('changePass')->name('change-pass');
});
