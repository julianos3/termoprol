<?php

//Auth::routes();
Route::redirect('/admin', '/admin/login');

// Authentication Routes...
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Admin\Auth\LoginController@login');
Route::post('admin/logout', 'Admin\Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('admin/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Admin\Auth\ResetPasswordController@reset');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {

    // HOME
    Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

    //BANNERS
    Route::group(['prefix' => 'banner', 'as' => 'banner.', 'namespace' => 'Banner'], function () {
        //DESKTOP
        Route::group(['prefix' => 'desktop', 'as' => 'desktop.'], function () {
            Route::get('', ['as' => 'index', 'uses' => 'BannerController@index']);
            Route::get('create', ['as' => 'create', 'uses' => 'BannerController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'BannerController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'BannerController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'BannerController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'BannerController@destroy']);
            Route::get('active/{id}', ['as' => 'active', 'uses' => 'BannerController@active']);
            Route::get('destroyImage/{id}', ['as' => 'destroyImage', 'uses' => 'BannerController@destroyImage']);
            Route::get('destroyVideo/{id}', ['as' => 'destroyVideo', 'uses' => 'BannerController@destroyVideo']);
        });

        //MOBILE
        Route::group(['prefix' => 'mobile', 'as' => 'mobile.'], function () {
            Route::get('', ['as' => 'index', 'uses' => 'BannerMobileController@index']);
            Route::get('create', ['as' => 'create', 'uses' => 'BannerMobileController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'BannerMobileController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'BannerMobileController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'BannerMobileController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'BannerMobileController@destroy']);
            Route::get('active/{id}', ['as' => 'active', 'uses' => 'BannerMobileController@active']);
            Route::get('destroyImage/{id}', ['as' => 'destroyImage', 'uses' => 'BannerMobileController@destroyImage']);
        });

        //PAGE
        Route::group(['prefix' => 'page', 'as' => 'page.'], function () {
            Route::get('', ['as' => 'index', 'uses' => 'BannerPageController@index']);
            Route::get('create', ['as' => 'create', 'uses' => 'BannerPageController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'BannerPageController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'BannerPageController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'BannerPageController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'BannerPageController@destroy']);
            Route::get('active/{id}', ['as' => 'active', 'uses' => 'BannerPageController@active']);
            Route::get('destroyImage/{id}', ['as' => 'destroyImage', 'uses' => 'BannerPageController@destroyImage']);
        });
    });

    //FORMS
    Route::group(['prefix' => 'form', 'as' => 'form.', 'namespace' => 'Form'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'FormController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'FormController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'FormController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'FormController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'FormController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'FormController@destroy']);
        Route::get('active/{id}', ['as' => 'active', 'uses' => 'FormController@active']);

        //EMAILS
        Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
            Route::get('{id}', ['as' => 'index', 'uses' => 'FormEmailController@index']);
            Route::post('store', ['as' => 'store', 'uses' => 'FormEmailController@store']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'FormEmailController@destroy']);
        });
    });

    //LANDING PAGE
    Route::group(['prefix' => 'landing-page', 'as' => 'landing-page.', 'namespace' => 'LandingPage'], function () {

        Route::get('', ['as' => 'index', 'uses' => 'LandingPageController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'LandingPageController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'LandingPageController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'LandingPageController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'LandingPageController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'LandingPageController@destroy']);
        Route::get('active/{id}', ['as' => 'active', 'uses' => 'LandingPageController@active']);
        Route::get('destroyFile/{id}/{name}', ['as' => 'destroyFile', 'uses' => 'LandingPageController@destroyFile']);

        //PRODUCT
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/{id}', ['as' => 'index', 'uses' => 'LandingPageProductController@index']);
            Route::get('create/{id}', ['as' => 'create', 'uses' => 'LandingPageProductController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'LandingPageProductController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'LandingPageProductController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'LandingPageProductController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'LandingPageProductController@destroy']);
            Route::get('active/{id}', ['as' => 'active', 'uses' => 'LandingPageProductController@active']);
            Route::get('destroyFile/{id}/{name}', ['as' => 'destroyFile', 'uses' => 'LandingPageProductController@destroyFile']);
        });

        //CONTACT
        Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
            Route::get('', ['as' => 'all', 'uses' => 'LandingPageContactController@all']);
            Route::get('{id}', ['as' => 'index', 'uses' => 'LandingPageContactController@index']);
            Route::get('show/{id}', ['as' => 'show', 'uses' => 'LandingPageContactController@show']);
            Route::get('export/{id}', ['as' => 'export', 'uses' => 'LandingPageContactController@export']);
            Route::get('exportAll', ['as' => 'exportAll', 'uses' => 'LandingPageContactController@exportAll']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'LandingPageContactController@destroy']);
        });
    });

    //PAGE
    Route::group(['prefix' => 'page', 'as' => 'page.', 'namespace' => 'Page'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'PageController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'PageController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PageController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PageController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PageController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'PageController@destroy']);
        Route::get('active/{id}', ['as' => 'active', 'uses' => 'PageController@active']);
        Route::get('destroyImage/{id}', ['as' => 'destroyImage', 'uses' => 'PageController@destroyImage']);

        //GALERY
        Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
            Route::get('{id}', ['as' => 'index', 'uses' => 'PageImageController@index']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'PageImageController@destroy']);
            Route::post('upload/{id}', ['as' => 'upload', 'uses' => 'PageImageController@upload']);
            Route::post('updateLabel/{id}', ['as' => 'updateLabel', 'uses' => 'PageImageController@updateLabel']);
            Route::post('cover/{id}', ['as' => 'cover', 'uses' => 'PageImageController@cover']);
            Route::post('order/{id}', ['as' => 'order', 'uses' => 'PageImageController@order']);
            Route::post('store', ['as' => 'store', 'uses' => 'PageImageController@store']);
            Route::get('destroyGallery/{id}', ['as' => 'destroyGallery', 'uses' => 'PageImageController@destroyAll']);
        });
    });

    //NEWSLETTER
    Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'NewsletterController@index']);
        Route::get('show/{id}', ['as' => 'show', 'uses' => 'NewsletterController@show']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'NewsletterController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'NewsletterController@destroy']);
        Route::get('export', ['as' => 'export', 'uses' => 'NewsletterController@export']);
        Route::get('destroyAllMessages', ['as' => 'destroyAllMessages', 'uses' => 'NewsletterController@destroyAllMessages']);
    });

    //CONFIGURATIONS
    Route::group(['prefix' => 'configuration', 'as' => 'configuration.', 'namespace' => 'Configuration'], function () {

        //CONFIGURATIONS
        Route::group(['prefix' => 'configuration', 'as' => 'configuration.', 'namespace' => 'Configuration'], function () {
            Route::get('', ['as' => 'index', 'uses' => 'ConfigurationController@index']);
            Route::get('create', ['as' => 'create', 'uses' => 'ConfigurationController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'ConfigurationController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ConfigurationController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'ConfigurationController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'ConfigurationController@destroy']);
        });

        //USERS
        Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {
            Route::get('', ['as' => 'index', 'uses' => 'UserController@index']);
            Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'UserController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'UserController@destroy']);
            Route::get('active/{id}', ['as' => 'active', 'uses' => 'UserController@active']);
            Route::get('destroyImage/{id}', ['as' => 'destroyImage', 'uses' => 'UserController@destroyImage']);

            Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
                Route::get('{id}', ['as' => 'edit', 'uses' => 'UserPasswordController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserPasswordController@update']);
            });
        });
    });

});