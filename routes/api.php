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
    Route::GET('/getHomePageIcons', 'RestController@getHomePageIcons');
    Route::GET('/getRequestAQuoteImage', 'RestController@getRequestAQuoteImage');
    Route::GET('/getContactImage', 'RestController@getContactImage');
    Route::GET('/getServices', 'RestController@getServices');
    Route::GET('/getOurTeamImage', 'RestController@getOurTeamImage');
    Route::GET('/getOurTeam', 'RestController@getOurTeam');
    Route::GET('/getWorksWithUsImage', 'RestController@getWorksWithUsImage');
    Route::GET('/getOurWorksImage', 'RestController@getOurWorksImage');
    Route::GET('/getOurWorks', 'RestController@getOurWorks');
    Route::GET('/getOurWorksByCategory', 'RestController@getOurWorksByCategory');
    Route::GET('/getOurWorksOrder', 'RestController@getOurWorksOrder');
    Route::GET('/getShopImage', 'RestController@getShopImage');
    Route::GET('/getShopByCategory', 'RestController@getShopByCategory');
    Route::GET('/getAllShop', 'RestController@getAllShop');
    Route::GET('/getCategory', 'RestController@getCategory');
    Route::POST('/AddContact', 'RestController@AddContact');
    Route::POST('/AddWorkWithUs', 'RestController@AddWorkWithUs');
    Route::POST('/AddRequestAQuote', 'RestController@AddRequestAQuote');

});
