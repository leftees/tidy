<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {

    Route::group(['prefix' => 'info'], function () {
        Route::get('server-time', 'InfoController@serverTime');
    });
    
    
    // Authentication
    Route::post('authenticate', 'AuthenticationController@authenticate');
    Route::get('authenticate', 'AuthenticationController@authenticate');
    Route::get('authenticate/invalidate', 'AuthenticationController@invalidate');
    Route::get('user/active', 'UserController@getActiveUser');
    
    // Routes that require a token
    Route::group(['middleware' => 'jwt.auth'], function () {
        
        // Menu
        Route::get('menu', 'MenuController@menuItems');
        
    });

});

Route::get('/', function () {
    return view('welcome');
});
