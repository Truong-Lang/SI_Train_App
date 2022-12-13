<?php

use App\Common\Constant;
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

Route::group(['prefix' => Constant::FOLDER_URL_ADMIN_ROUTE], function () {
    Route::get('/', Constant::FOLDER_URL_ADMIN . '\HomeController@index')
        ->name(Constant::FOLDER_URL_ADMIN . '.home_page');
    Route::get('/home', Constant::FOLDER_URL_ADMIN . '\HomeController@index')
        ->name(Constant::FOLDER_URL_ADMIN . '.home_page');

    // Authentication Routes...
    Route::get('/login', Constant::FOLDER_URL_ADMIN . '\Auth\LoginController@showLoginForm')
        ->name(Constant::FOLDER_URL_ADMIN . '.auth.showLogin');
    Route::post('/', Constant::FOLDER_URL_ADMIN . '\Auth\LoginController@login')
        ->name(Constant::FOLDER_URL_ADMIN . '.auth.login');
    Route::post('/logout', Constant::FOLDER_URL_ADMIN . '\Auth\LoginController@logout')
        ->name(Constant::FOLDER_URL_ADMIN . '.logout');

    // Registration Routes...
    Route::get('/register', Constant::FOLDER_URL_ADMIN . '\Auth\RegisterController@showRegistrationForm')
        ->name(Constant::FOLDER_URL_ADMIN.'.auth.showRegister');
    Route::post('/register', Constant::FOLDER_URL_ADMIN . '\Auth\RegisterController@register')
        ->name(Constant::FOLDER_URL_ADMIN.'.auth.register');

    // Password Reset Routes...
    Route::group(['prefix' => 'password'], function () {
        Route::get('/reset', Constant::FOLDER_URL_ADMIN . '\Auth\ForgotPasswordController@showLinkRequestForm')
            ->name(Constant::FOLDER_URL_ADMIN.'.password.email');
        Route::post('/email', Constant::FOLDER_URL_ADMIN . '\Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::get('/reset/{token}', Constant::FOLDER_URL_ADMIN . '\Auth\ResetPasswordController@showResetForm');
        Route::post('/reset', Constant::FOLDER_URL_ADMIN . '\Auth\ResetPasswordController@reset');
    });

    // Category Routes...
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', Constant::FOLDER_URL_ADMIN . '\Category\CategoryController@index')
            ->name(Constant::FOLDER_URL_ADMIN.'.category.index');
        Route::get('/create-edit/{id?}', Constant::FOLDER_URL_ADMIN . '\Category\CategoryController@createAndEdit')
            ->name(Constant::FOLDER_URL_ADMIN.'.category.createAndEdit');
        Route::post('/store', Constant::FOLDER_URL_ADMIN . '\Category\CategoryController@store')
            ->name(Constant::FOLDER_URL_ADMIN.'.category.store');
        Route::post('/', Constant::FOLDER_URL_ADMIN . '\Category\CategoryController@delete');
    });

    // Profile Routes...
    Route::group(['prefix' => 'profile'], function () {
        Route::resource('user', Constant::FOLDER_URL_ADMIN . '\User\UserController', ['except' => ['show']]);
        Route::get('/', ['as' => 'profile.edit', 'uses' => Constant::FOLDER_URL_ADMIN . '\Profile\ProfileController@edit']);
        Route::put('/', ['as' => 'profile.update', 'uses' => Constant::FOLDER_URL_ADMIN . '\Profile\ProfileController@update']);
        Route::put('/password',
            ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    });

    // News Routes...
    Route::group(['prefix' => 'news'], function () {
        Route::get('/', Constant::FOLDER_URL_ADMIN . '\News\NewsController@index')
            ->name(Constant::FOLDER_URL_ADMIN.'.news.index');
        Route::get('/create-edit/{id?}', Constant::FOLDER_URL_ADMIN . '\News\NewsController@createAndEdit')
            ->name(Constant::FOLDER_URL_ADMIN.'.news.createAndEdit');
        Route::post('/store', Constant::FOLDER_URL_ADMIN . '\News\NewsController@store')
            ->name(Constant::FOLDER_URL_ADMIN.'.news.store');
        Route::post('/', Constant::FOLDER_URL_ADMIN . '\News\NewsController@delete');
    });
});
