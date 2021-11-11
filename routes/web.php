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
Route::group(['prefix'=>'joyCenter','middleware'=>['auth','joyCenter']],function(){
    Route::get('/{any}',function(){
        return view("joyCenter/home");
    })->name('joyHome')->where('any','.*');
});
//Grace center
Route::group(['prefix'=>'grace_center','middleware'=>'auth'],function(){
    Route::get('/{any}',function(){
        return view("medical/grace_center/home");
    })->name('grace_home')->where('any','.*');
});
//cash
Route::group(['prefix'=>'cashier','middleware'=>'auth'],function(){
    Route::get('invoices/payment/{data}',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'print_invoice']);
    Route::get('invoices/cash_receipt',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'cash_receipt']);
    Route::get('/{any}',function(){
        return view("cashier/home");
    })->name('cashier_home')->where('any','.*');
});
//generalist
Route::group(['prefix'=>'generalist','middleware'=>'auth'],function(){
    Route::get('invoices/payment/{data}',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'print_invoice']);
    Route::get('overview/{admission_id}',[\App\Http\Controllers\V1\patient_system\out_patient\general\GeneralistController::class,'overview']);
    Route::get('/{any}',function(){
        return view("medical/generalist/home");
    })->name('generalist_home')->where('any','.*');
});
//dentist
Route::group(['prefix'=>'dentist','middleware'=>'auth'],function(){
    Route::get('/{any}',function(){
        return view("medical/dentist/home");
    })->name('dentist_home')->where('any','.*');
});
//Laboratory Station
Route::group(['prefix'=>'nurse_station','middleware'=>'auth'],function(){
    Route::get('/{any}',function(){
        return view("medical/nurse_station/home");
    })->name('nurse_station_home')->where('any','.*');
});
//Inventory system
Route::group(['prefix'=>'inventory_system'],function(){
    Route::get('/pdf/shopping_list/{id}',[\App\Http\Controllers\V1\inventory_system\pdf\PdfController::class,'shopping_list']);
    Route::get('/pdf/stock_entry/{id}',[\App\Http\Controllers\V1\inventory_system\pdf\PdfController::class,'stock_entry']);
    Route::get('/pdf/delivered_out/{id}',[\App\Http\Controllers\V1\inventory_system\pdf\PdfController::class,'delivered_out']);
    Route::get('/{any}',function(){
        return view("inventory_system/home");
    })->name('inventory_home')->where('any','.*');
});
