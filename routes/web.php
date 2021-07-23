<?php

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
    Route::post('survey/getcity', [SurveyController::class, 'get_city'])->name('survey.getcity');
});
