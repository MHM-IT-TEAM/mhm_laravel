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



//auth
Auth::routes();
Route::get('/auth/login',[App\Http\Controllers\authController::class,'index']);
//landing page
Route::get('/', function () {
    return view('welcome');
});
//joyCenter
Route::group(['prefix'=>'joyCenter','middleware'=>['auth','joyCenter']],function(){
    Route::get('/{any}',[App\Http\Controllers\joyCenter\JoyCenterController::class, 'index'])->name('joyHome')->where('any','.*');
});
//cash
Route::group(['prefix'=>'cash','middleware'=>'auth'],function(){
    route::get('/home',[App\Http\Controllers\cash\cashController::class, 'index'])->name('cashHome');
    route::get('/home/list',[App\Http\Controllers\cash\cashController::class, 'patient_list'])->name('cash_patient_list');
    route::Get('/home/pay/{consult_id}/patId/{patient_id}/type_consult/{type_consult}',[App\Http\Controllers\cash\cashController::class, 'pay'] )->name('cash_pay');
});
//obstetrics
Route::group(['prefix'=>'obstetrics','middleware'=>'auth'],function(){

    Route::get('/{any}',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class, 'index'])->where('any','.*');
});
// Maternity
Route::group(['prefix'=>'maternity','middleware'=>'auth'],function(){
    Route::get('/{any}',[App\Http\Controllers\medical\maternity\MaternityController::class, 'index'])->where('any','.*');
});
// Generalist
Route::group(['prefix'=>'generalist','middleware'=>'auth'],function(){
    Route::get('/{any}',[App\Http\Controllers\medical\generalist\GeneralistController::class, 'index'])->where('any','.*');
});
//Overviews
Route::group(['prefix'=>'overview','middleware'=>'auth'],function(){

    Route::get('/{any}',[\App\Http\Controllers\medical\overviews\OverviewController::class, 'index'])->where('any','.*');
});
