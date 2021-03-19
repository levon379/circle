<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Rest'], function () {
    Route::POST('/job-application', 'RestController@addJobApplicaion');
    Route::POST('/subscriber', 'RestController@addSubscriber');
    Route::GET('/getProductsByCategory/{id}', 'RestController@getAllProductsByCategory');
    Route::GET('/getCategory/{id}', 'RestController@getCategoryById');
    Route::GET('/getSliderData', 'RestController@getSliders');
    Route::GET('/getAboutUsData', 'RestController@getAboutUsData');
    Route::GET('/getMedia', 'RestController@getMedia');
    Route::GET('/getWhyTahweel', 'RestController@getWhyTahweel');
    Route::GET('/getOverview', 'RestController@getOverview');
    Route::GET('/getMissionVission', 'RestController@getMissionVission');
    Route::GET('/getHistory', 'RestController@getHistory');
    Route::GET('/getTwahweelIntegrated', 'RestController@getTwahweelIntegrated');
    Route::GET('/getHealTyAndSafety', 'RestController@getHealTyAndSafety');
    Route::GET('/getAroundWorld', 'RestController@getAroundWorld');
    Route::GET('/getTahweelPeople', 'RestController@getTahweelPeople');
    Route::GET('/getCareer', 'RestController@getCareer');
    Route::GET('/getContactUs', 'RestController@getContactUs');
    Route::GET('/getCategories', 'RestController@getCategories');
});
