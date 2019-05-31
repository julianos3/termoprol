<?php

include ('admin.php');
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

//LANDING PAGE / CAMPANHA
Route::group(['prefix' => 'campanha', 'as' => 'landing-page.', 'namespace' => 'LandingPage'], function () {
    Route::get('/', 'LandingPageController@index')->name('index');
    Route::get('/{seo_link}', 'LandingPageController@show')->name('show');
    Route::post('/store', 'LandingPageContactController@store')->name('store');
});

Route::group(['namespace' => 'Site'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});
