<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\centralized\patientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// return countries list
Route::get('/countries',[App\Http\Controllers\centralized\CountryController::class, 'index']);
// return fokontany list
Route::get('/fokontany',[App\Http\Controllers\centralized\fktController::class, 'index']);

//patient routes
Route::get('/patients/search/',[App\Http\Controllers\centralized\patientController::class, 'search']);
Route::resource('/patients',patientController::class);
