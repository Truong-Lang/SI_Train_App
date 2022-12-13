<?php

use App\Common\Constant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Routes...
Route::get('/{categoryAlias?}', Constant::FOLDER_URL_FRONTEND . '\News\NewsController@index')
    ->name(Constant::FOLDER_URL_FRONTEND . '.news.index');
Route::get('/{categoryAlias?}/{newsAlias?}', Constant::FOLDER_URL_FRONTEND . '\News\NewsController@getDataNewsDetail')
    ->name(Constant::FOLDER_URL_FRONTEND . '.news.detail');