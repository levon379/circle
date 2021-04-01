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

//web page part
Route::group(['namespace' => 'Site'], function () {
    Route::get('/', 'HomeController@index');
});


//Admin dashboard part
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('/', 'AdminController');

    Route::resource('/home-page', 'HomePageController');
    Route::resource('/our-team', 'OurTeamController');

    Route::prefix('request-quote')->group(function () {
        Route::resource('/', 'RequestQuoteController');
        Route::DELETE('/{request_id}/destroy-image/{image_id}', 'RequestQuoteController@destroyImage');
        Route::GET('/{id}/edit', 'RequestQuoteController@edit');
        Route::POST('/{id}/delete', 'RequestQuoteController@destroyQuote');
        Route::get('/{id}', 'RequestQuoteController@show');
    });
    Route::prefix('quote-main')->group(function () {
        Route::GET('/', 'RequestQuoteMainController@quoteMain');
        Route::GET('/{id}/edit', 'RequestQuoteMainController@quoteMainEdit');
        Route::PUT('/{id}', 'RequestQuoteMainController@quoteMainStore');
    });
    Route::prefix('contact-main')->group(function () {
        Route::GET('/', 'ContactMainController@contactMain');
        Route::GET('/{id}/edit', 'ContactMainController@contactMainEdit');
        Route::PUT('/{id}', 'ContactMainController@contactMainStore');
    });
    Route::prefix('contact-us')->group(function () {
        Route::resource('/', 'ContactController');
        Route::DELETE('/{request_id}/destroy-image/{image_id}', 'ContactController@destroyImage');
        Route::GET('/{id}/edit', 'ContactController@edit');
        Route::POST('/{id}/delete', 'ContactController@destroyContact');
        Route::get('/{id}', 'ContactController@show');
    });
    Route::prefix('our-team-main')->group(function () {
        Route::GET('/', 'OurTeamMainController@teamMain');
        Route::GET('/{id}/edit', 'OurTeamMainController@teamMainEdit');
        Route::PUT('/{id}', 'OurTeamMainController@teamMainStore');
    });
    Route::prefix('work-with-us-main')->group(function () {

        Route::GET('/', 'WorkWithUsMainController@withUsMain');
        Route::GET('/{id}/edit', 'WorkWithUsMainController@workWithUsMainEdit');
        Route::PUT('/{id}', 'WorkWithUsMainController@workWithUsMainStore');
    });
    Route::prefix('our-services')->group(function () {
        Route::resource('/', 'OurServicesController');
        Route::GET('/{id}/edit', 'OurServicesController@edit');
        Route::POST('/{id}/delete', 'OurServicesController@destroyProduct');
        Route::PUT('/{id}', 'OurServicesController@update');
        Route::POST('/update-ordering', 'OurServicesController@updateOrdering');
    });
    Route::prefix('our-works-main')->group(function () {
        Route::GET('/', 'OurWorksMainController@main');
        Route::GET('/{id}/edit', 'OurWorksMainController@edit');
        Route::PUT('/{id}', 'OurWorksMainController@store');
    });
    Route::prefix('our-works')->group(function () {
        Route::resource('/', 'OurWorksController');
        Route::GET('/{id}/edit', 'OurWorksController@edit');
        Route::PUT('/{id}', 'OurWorksController@update');
        Route::POST('/{id}/delete', 'OurWorksController@destroyWork');
    });
    Route::prefix('work-with-us')->group(function () {
        Route::resource('/', 'WorkWithUsController');
        Route::DELETE('/{request_id}/destroy-image/{image_id}', 'WorkWithUsController@destroyImage');
        Route::GET('/{id}/edit', 'WorkWithUsController@edit');
        Route::POST('/{id}/delete', 'WorkWithUsController@destroyQuote');
        Route::get('/{id}', 'WorkWithUsController@show');
    });

});
