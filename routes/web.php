<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/{any}', [App\Http\Controllers\VueController::class, 'index'])->where('any','.*');

//joyCenter
Route::group(['prefix'=>'joyCenter'],function(){
    Route::get('/home',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'index'])->name('joyHome');
    Route::get('/patient',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'patient']);
    Route::get('/queue',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'queue']);
    Route::get('/consultation',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'consultation']);
});


