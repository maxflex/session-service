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

Route::prefix('sessions')->namespace('Api')->group(function() {
    Route::post('action', 'SessionsController@action');
    Route::get('exists/{user_id}', 'SessionsController@exists');
    Route::get('destroy/{user_id}', 'SessionsController@destroy');
});
