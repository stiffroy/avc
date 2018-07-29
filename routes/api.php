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
    Route::post('client/notified', 'Api\ClientController@notificationChecked')->name('notified');

    Route::apiResources([
        'clients'   => 'Api\ClientController',
        'groups'    => 'Api\GroupController',
        'users'     => 'Api\UserController',
    ]);
});
