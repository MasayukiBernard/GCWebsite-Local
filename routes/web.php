<?php

use Illuminate\Support\Facades\Log;
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
        Route::name('staff.')->group(function(){
            Route::prefix('staff')->group(function(){
                Route::prefix('home')->group(function(){
                    $home_controller = 'HomeController@';
                    Route::get('/', $home_controller . 'staff_index')->name('home');
                    Route::post('academic-year/{id}', $home_controller . 'HomeController@get_percentages');
                });
                Route::prefix('application')->group(function(){
                    Route::get('/', 'User\ManageApplicationController@show_applicationPage')->name('application');
                });
                
                Route::name('academic-year.')->group(function(){
                    Route::prefix('academic-year')->group(function(){
                        $year_controller = "User\ManageAcademicYearController@";

                        Route::get('/', $year_controller . 'show_academicYearPage')->name('page');
                        Route::get('/create', $year_controller . 'show_createPage')->name('create-page');
                        Route::post('/create/confirm', $year_controller . 'confirm_create')->name('create-confirm');
                        Route::post('/create/academic-year', $year_controller . 'create')->name('create');

                        Route::post('/delete/confirm/{academic_year_id}', $year_controller . 'confirm_delete');
                        Route::post('/delete/academic-year', $year_controller . 'delete')->name('delete');
                    });
                });

                Route::name('partner.')->group(function(){
                    Route::prefix('partner')->group(function(){
                        $partner_controller = 'User\ManagePartnerController@';

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
                        $yPartner_controller = 'User\ManageYearlyPartnerController';
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

                Route::prefix('profile')->group(function(){
                    $profile_controller = 'User\ManageProfileController@';
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
    Route::post('/password/change', 'User\ManageProfileController@handle_ChangePass')
        ->middleware('changePass')->name('change-pass');
});
