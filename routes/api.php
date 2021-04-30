<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\OrderShipped;
use App\Mail\WorkWithUs;
use App\Mail\RequestQuote;
use Illuminate\Support\Facades\Mail;
use Response;

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
    Route::GET('/getVacancy', 'RestController@getVacancy');
    Route::GET('/getCareer', 'RestController@getCareer');
    Route::GET('/getCategory', 'RestController@getCategory');
    Route::POST('/addBlog', 'RestController@addBlog');
    Route::GET('/getBlog/{id}', 'RestController@getBlog');

    Route::POST('/AddContact', function () {
        $response = mail::to('info@circletechnicaldesign.com')->send(new OrderShipped());
        return Response::json(['response'=>$response]);
    });
    Route::POST('/AddWorkWithUs', function () {
        $response = mail::to('info@circletechnicaldesign.com')->send(new WorkWithUs());
        return Response::json(['response'=>$response]);
    });
    Route::POST('/AddRequestAQuote', function () {
        $response = mail::to('info@circletechnicaldesign.com')->send(new RequestQuote());
        return Response::json(['response'=>$response]);
    });

});
