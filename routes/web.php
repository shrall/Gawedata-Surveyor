<?php
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['surveyor']], function () {
    Route::get('edit-profile', [UserController::class, 'edit_profile'])->name('user.editprofile');
    Route::get('reset-password', [UserController::class, 'reset_password'])->name('user.resetpassword');
    Route::post('reset-password', [UserController::class, 'update_password'])->name('user.updatepassword');
    Route::resource('survey', SurveyController::class);
    Route::post('survey/filter_sort', [SurveyController::class, 'filter_sort'])->name('survey.filtersort');
    Route::get('survey/{id}/hasil', [SurveyController::class, 'hasil'])->name('survey.hasil');
    Route::get('survey/{id}/analisa', [SurveyController::class, 'analisa'])->name('survey.analisa');
    Route::get('survey/{id}/detail', [SurveyController::class, 'detail'])->name('survey.detail');
    Route::get('survey/{id}/{i}/{new}', [SurveyController::class, 'show'])->name('survey.show');
    Route::get('survey/{id}/submit', [SurveyController::class, 'submit'])->name('survey.submit');
    Route::post('survey/{id}/uploadphoto', [SurveyController::class, 'upload_photo'])->name('survey.uploadphoto');
    Route::post('survey/{id}/uploadphoto/grid', [SurveyController::class, 'grid_upload_photo'])->name('survey.griduploadphoto');
    Route::get('survey/{id}/submitted/question/{i}', [SurveyController::class, 'submitted'])->name('survey.submitted');
    Route::post('survey/getcity', [SurveyController::class, 'get_city'])->name('survey.getcity');
    Route::post('survey/{id}/addquestion', [SurveyController::class, 'add_question'])->name('survey.addquestion');
    Route::post('survey/refreshsingleanswer', [SurveyController::class, 'refresh_single_answer'])->name('survey.refreshsingleanswer');
    Route::post('survey/refreshsingleanswerskiplogic', [SurveyController::class, 'refresh_single_answer_skip_logic'])->name('survey.refreshsingleanswerskiplogic');
    Route::post('survey/refreshgridquestion', [SurveyController::class, 'refresh_grid_question'])->name('survey.refreshgridquestion');
    Route::post('survey/refreshgridanswer', [SurveyController::class, 'refresh_grid_answer'])->name('survey.refreshgridanswer');
    Route::put('survey/{survey}/changesettings', [SurveyController::class, 'change_settings'])->name('survey.changesettings');
    //assessment
    Route::resource('assessment', AssessmentController::class);
    Route::post('assessment/get_assessment', [AssessmentController::class, 'get_assessment'])->name('assessment.getassessment');
    Route::get('assessment/{id}/{i}/{new}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::get('assessment/{id}/hasil', [AssessmentController::class, 'hasil'])->name('assessment.hasil');
    Route::get('assessment/{id}/analisa', [AssessmentController::class, 'analisa'])->name('assessment.analisa');
    Route::get('assessment/{id}/detail', [AssessmentController::class, 'detail'])->name('assessment.detail');
    Route::get('assessment/{id}/submit', [AssessmentController::class, 'submit'])->name('assessment.submit');
    Route::get('assessment/{id}/pertanyaan', [AssessmentController::class, 'pertanyaan'])->name('assessment.pertanyaan');
    Route::get('assessment/{id}/kategori', [AssessmentController::class, 'kategori'])->name('assessment.kategori');
    Route::get('assessment/{id}/ranking', [AssessmentController::class, 'ranking'])->name('assessment.ranking');
    Route::get('assessment/{id}/submitted/question/{i}', [AssessmentController::class, 'submitted'])->name('assessment.submitted');
    Route::get('assessment/{id}/submitted/respondent/{i}', [AssessmentController::class, 'submitted_respondent'])->name('assessment.submitted.respondent');
    Route::post('assessment/refreshirtanswer', [AssessmentController::class, 'refresh_irt_answer'])->name('assessment.refreshirtanswer');
    Route::post('assessment/refreshrsanswer', [AssessmentController::class, 'refresh_rs_answer'])->name('assessment.refreshrsanswer');
    Route::post('assessment/refreshsaanswer', [AssessmentController::class, 'refresh_sa_answer'])->name('assessment.refreshsaanswer');
    Route::post('assessment/{id}/uploadphoto', [AssessmentController::class, 'upload_photo'])->name('assessment.uploadphoto');
    Route::post('assessment/uploadphotodiscussion', [AssessmentController::class, 'upload_photo_discussion'])->name('assessment.uploadphotodiscussion');
    Route::put('assessment/{assessment}/changesettings', [AssessmentController::class, 'change_settings'])->name('assessment.changesettings');
    //assessment - responden type
    Route::get('assessmentrespondent/{id}/{i}/{new}', [AssessmentController::class, 'show_respondent'])->name('assessment.showrespondent');
    Route::post('assessment/createrespondenttype', [AssessmentController::class, 'store_respondent_type'])->name('assessment.createrespondenttype');
    Route::post('assessment/updaterespondenttype', [AssessmentController::class, 'update_respondent_type'])->name('assessment.updaterespondenttype');
    Route::post('assessment/deleterespondenttype', [AssessmentController::class, 'delete_respondent_type'])->name('assessment.deleterespondenttype');
});
