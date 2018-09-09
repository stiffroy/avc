<?php

/**
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1/')->group(function () {
    Route::post('client/heartbeat', 'Api\ClientController@heartbeat')->name('heartbeat');
    Route::post('client/alive', 'Api\ClientController@makeAlive')->name('alive');
    Route::get('clients/user/{userId}', 'Api\ClientController@clientsByUser')->name('clients.by.user');

    Route::apiResources([
        'clients'   => 'Api\ClientController',
        'groups'    => 'Api\GroupController',
        'users'     => 'Api\UserController',
    ]);

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'Api\AuthController@login');
        Route::post('logout', 'Api\AuthController@logout');
        Route::post('refresh', 'Api\AuthController@refresh');
        Route::post('me', 'Api\AuthController@me');

    });
});
