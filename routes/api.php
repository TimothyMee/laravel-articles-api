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

Route::get('/', 'PassportController@index')->name('login');
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
 
Route::get('articles', 'ArticleController@getAll');
Route::get('articles/{id}', 'ArticleController@show');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');

    Route::get('my-articles', 'ArticleController@index');
    Route::put('articles/{id}', 'ArticleController@update');
    Route::post('articles', 'ArticleController@store');
    Route::delete('articles/{id}', 'ArticleController@destroy');
});
