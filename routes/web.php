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



//auth
Auth::routes();
// home
Route::get('/home',function(){
    $user= Auth::user();
    $pages=$user->pages()->get();
    return view('/home')->with('pages',$pages);
});
Route::get('/auth/login',[App\Http\Controllers\authController::class,'index']);
//landing page
Route::get('/', function () {
    return view('welcome');
});
//joyCenter
Route::group(['prefix'=>'joyCenter','middleware'=>'auth'],function(){
    Route::get('/{any}',function(){
        return view("joyCenter/home");
    })->name('joyHome')->where('any','.*');
});
//cash
Route::group(['prefix'=>'cashier','middleware'=>'auth'],function(){
    Route::get('invoices/payment/{data}',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'print_invoice']);
    Route::get('invoices/cash_receipt',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'cash_receipt']);
    Route::get('/{any}',function(){
        return view("cashier/home");
    })->name('cashier_home')->where('any','.*');
});
