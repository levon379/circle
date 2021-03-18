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

    Route::resource('/contact-us', 'ContactUsController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/product-tabs', 'ProductTabsController');
    Route::resource('/about-us', 'AboutUsController');

    Route::GET('/overview', 'AboutUsController@overview');
    Route::GET('/overview/{id}/edit', 'AboutUsController@overviewEdit');
    Route::PUT('/overview/{id}', 'AboutUsController@overviewStore');

    Route::GET('/integrated', 'AboutUsController@integrated');
    Route::GET('/integrated/{id}/edit', 'AboutUsController@integratedEdit');
    Route::PUT('/integrated/{id}', 'AboutUsController@integratedStore');

    Route::GET('/mission-vision', 'AboutUsController@integrated');
    Route::GET('/mission-vision/{id}/edit', 'AboutUsController@missionVisionEdit');
    Route::PUT('/mission-vision/{id}', 'AboutUsController@missionVisionStore');

    Route::GET('/history', 'AboutUsController@history');
    Route::GET('/history/{id}/edit', 'AboutUsController@historyEdit');
    Route::PUT('/history/{id}', 'AboutUsController@historyStore');

    Route::GET('/around-world', 'AboutUsController@aroundWorld');
    Route::GET('/around-world/{id}/edit', 'AboutUsController@aroundWorldEdit');
    Route::PUT('/around-world/{id}', 'AboutUsController@aroundWorldStore');

    Route::GET('/health-safety', 'AboutUsController@healthSafety');
    Route::GET('/health-safety/{id}/edit', 'AboutUsController@healthSafetyEdit');
    Route::PUT('/health-safety/{id}', 'AboutUsController@healthSafetyStore');

    Route::GET('/people', 'AboutUsController@people');
    Route::GET('/people/{id}/edit', 'AboutUsController@peopleEdit');
    Route::PUT('/people/{id}', 'AboutUsController@peopleStore');

    Route::GET('/career', 'ContactUsController@career');
    Route::GET('/career/{id}/edit', 'ContactUsController@careerEdit');
    Route::PUT('/career/{id}', 'ContactUsController@careerStore');

    //Route::POST('/about-us/overview', 'AboutUsController@overview');
    Route::GET('/integrated', 'AboutUsController@integrated');
    Route::GET('/mission-vision', 'AboutUsController@missionVision');
    Route::GET('/history', 'AboutUsController@history');
    Route::GET('/around-world', 'AboutUsController@aroundWorld');
    Route::GET('/health-safety', 'AboutUsController@healthSafety');
    Route::GET('/people', 'AboutUsController@people');

    //Route::GET('/career', 'AboutUsController@career');

    Route::resource('/mail-settings', 'MailSettingsController');
    Route::resource('/slider', 'SliderController');
    Route::resource('/why-tahweel', 'WhyTahweelController');
    Route::POST('/why-tahweel/update-ordering', 'WhyTahweelController@updateOrdering');
    Route::POST('/slider/update-ordering', 'SliderController@updateOrdering');
    Route::POST('/product-tabs/update-ordering', 'ProductTabsController@updateOrdering');
    Route::get('/subscriber', 'SubscriberController@index');
    Route::DELETE('/subscriber/{id}', 'SubscriberController@destroy');

    Route::get('/job-application', 'JobApplicationController@index');
    Route::get('/job-application/show/{id}', 'JobApplicationController@show');
    Route::DELETE('/job-application/{id}', 'JobApplicationController@destroy');

    Route::resource('/social', 'SocialController');
    Route::resource('/vacancies', 'VacancyController');
    Route::resource('/catalog', 'CatalogController');

    Route::resource('/media-center', 'MediaCenterController');
    Route::DELETE('/media-center/{media_id}/destroy-image/{image_id}', 'MediaCenterController@destroyImage');
    Route::POST('/media-center/update-ordering', 'MediaCenterController@updateOrdering');

    //Route::resource('/press-releases', 'PressReleaseController');
    //Route::DELETE('/press-releases/{media_id}/destroy-image/{image_id}', 'NewsletterController@destroyImage');

    Route::prefix('products')->group(function () {
        Route::resource('/', 'ProductController');
        Route::GET('/details', 'ProductController@details');
        Route::DELETE('/{product_id}/destroy-image/{image_id}', 'ProductController@destroyImage');
        Route::GET('/{id}/specification', 'ProductController@specification');
        Route::POST('/{id}/specification', 'ProductController@specificationStore');
        Route::GET('/{id}/edit', 'ProductController@edit');
        Route::POST('/{id}/delete', 'ProductController@destroyProduct');
        Route::PUT('/{id}', 'ProductController@update');

        Route::POST('/ajax-delete', 'ProductController@ajaxDelete');
        Route::POST('/ajax-edit', 'ProductController@ajaxEdit');
        Route::POST('/ajax-get', 'ProductController@ajaxGet');
        Route::GET('/{id}/featured', 'ProductController@featured');
        Route::POST('/{id}/featured-store', 'ProductController@featuredStore');
        Route::POST('/update-ordering', 'ProductController@updateOrdering');
    });

});
