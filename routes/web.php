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
    return view('vue');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/{any}', [App\Http\Controllers\VueController::class, 'index'])->where('any','.*');

//joyCenter
Route::group(['prefix'=>'joyCenter','middleware'=>'auth'],function(){
//    Route::get('/consultation',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'consultation']);
    Route::get('/queue',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'queue']);
    Route::get('/{any}',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'index'])->name('joyHome')->where('any','.*');
});
//cash
Route::group(['prefix'=>'cash','middleware'=>'auth'],function(){
    route::get('/home',[App\Http\Controllers\cash\cashController::class, 'index'])->name('cashHome');
    route::get('/home/list',[App\Http\Controllers\cash\cashController::class, 'patient_list'])->name('cash_patient_list');
    route::Get('/home/pay/{consult_id}/patId/{patient_id}/type_consult/{type_consult}',[App\Http\Controllers\cash\cashController::class, 'pay'] )->name('cash_pay');
});
//obstetrics
Route::group(['prefix'=>'obstetrics'],function(){
    route::get('/baby/weight_overview',[App\Http\Controllers\medical\obstetrics\BabyController::class,'index']);
});

