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
    Route::get('clients/user/{id}', 'ClientController@clientsByUser')->name('clients.by.user');
    Route::post('client/alive', 'ClientController@makeAlive')->name('alive');
    Route::post('client/heartbeat', 'ApiController@heartbeat')->name('heartbeat');
    Route::get('groups/user/{id}', 'GroupController@groupsByUser')->name('groups.by.user');
    Route::get('group/chart/{id}', 'GroupController@getChart')->name('chart');
    Route::post('group/store-report', 'ApiController@storeReport')->name('storeReport');

    Route::apiResources([
        'clients'       => 'ClientController',
        'groups'        => 'GroupController',
        'users'         => 'UserController',
        'statistics'    => 'StatisticsController',
    ]);

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });
});
