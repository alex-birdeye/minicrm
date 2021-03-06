<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/companies', 'CompanyController');
    Route::get('/companies-autocomplete', 'CompanyController@autocomplete');
    Route::resource('/emploees', 'EmploeeController');
//    Route::post('logout', 'AuthController@logout');
});

Route::get('/langs', 'LocalizationController@index');
Route::get('/locale', 'LocalizationController@getLocale');
Route::get('/locale/{locale}', 'LocalizationController@setLocale');
