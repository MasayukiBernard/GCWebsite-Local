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
                    Route::get('/', 'HomeController@staff_index')->name('home');
                    Route::post('academic_year/{id}', 'HomeController@get_percentages');
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
                        Route::get('/', 'User\ManagePartnerController@show_partnerPage')->name('page');
                        Route::post('/major/{id}', 'User\ManagePartnerController@show_major_partners');
    
                        Route::get('/create', 'User\ManagePartnerController@show_createPage')->name('create-page');
                        Route::post('/create/confirm', 'User\ManagePartnerController@confirm_create')->name('create-confirm');
                        Route::post('/create/master-partner', 'User\ManagePartnerController@create')->name('create');
    
                        Route::get('/details/{partner}', 'User\ManagePartnerController@show_partner_details');
                        Route::get('/edit/{partner}', 'User\ManagePartnerController@show_editPage')->name('edit-page');
                        Route::post('/update/confirm', 'User\ManagePartnerController@confirm_update')->name('update-confirm');
                        Route::post('/update/master-partner', 'User\ManagePartnerController@update')->name('update');
                        Route::post('/delete/master-partner/', 'User\ManagePartnerController@delete')->name('delete');
                    });
                });

                Route::name('yearly-partner.')->group(function(){
                    Route::prefix('yearly-partner')->group(function(){
                        Route::get('/', 'User\ManageYearlyPartnerController@show_yearlyPartnerPage')->name('page');

                        Route::get('/create', 'User\ManageYearlyPartnerController@show_createPage')->name('create-page');
                        Route::post('/academic-year/{id}/partners', 'User\ManageYearlyPartnerController@show_unpicked_partners');
                        Route::post('/create/confirm', 'User\ManageYearlyPartnerController@confirm_create')->name('create-confirm');
                        Route::post('/create/yearly-partner', 'User\ManageYearlyPartnerController@create')->name('create');

                        Route::get('/list/{academic_year_id}', 'User\ManageYearlyPartnerController@show_yearlyPartnerDetails')->name('details');
                        Route::post('/delete/confirm/{yearly_partner_id}', 'User\ManageYearlyPartnerController@confirm_delete');
                        Route::post('/delete/yearly-partner/', 'User\ManageYearlyPartnerController@delete')->name('delete');
                    });
                });

                Route::prefix('profile')->group(function(){
                    Route::get('/', 'User\ManageProfileController@show_staffProfile')->name('profile');
                    Route::get('change-pass', 'User\ManageProfileController@show_changePass')
                        ->middleware('password.confirm')->name('change-pass-view');;
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
                    Route::get('/', 'User\ManageProfileController@show_studentProfile')->name('profile');
                    Route::get('change-pass', 'User\ManageProfileController@show_changePass')
                        ->middleware('password.confirm')->name('change-pass-view');
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

// create route which does not show in address bar, like logout, using form action
Route::get('ensure-user');
