<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\AdminController;
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
Route::get('/login', function () {
    return view('auth\login');
})->name('login');

Route::get('/register', function () {
    return view('auth\register');
})->name('register');



Route::get('/',[HomeController::class,'index']);

Route::get('/home',[HomeController::class,'redirect']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/add_coach_view',[AdminController::class,'addview']);

Route::post('/upload_coach',[AdminController::class,'upload']);

Route::post('/appointment',[HomeController::class,'appointment']);

Route::get('/myappointmentlist',[HomeController::class,'myappointmentlist']);

Route::get('/user_appoint_cancel/{id}',[HomeController::class,'user_appoint_cancel']);

Route::get('/current_appointments',[AdminController::class,'current_appointments']);

Route::get('/approved/{id}',[AdminController::class,'approved']);

Route::get('/cancelled/{id}',[AdminController::class,'cancelled']);

Route::get('/show_coaches',[AdminController::class,'show_coaches']);

Route::get('/deletecoach/{id}',[AdminController::class,'deletecoach']);

Route::get('/updatecoach/{id}',[AdminController::class,'updatecoach']);

Route::post('/editcoach/{id}',[AdminController::class,'editcoach']);

Route::get('/sendemail/{id}',[AdminController::class,'sendemail']);

Route::post('/emailnotify/{id}',[AdminController::class,'emailnotify']);