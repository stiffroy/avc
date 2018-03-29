<?php

/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'DashboardController@index')->name('home');

Route::group(['prefix' => 'client', 'middleware' => ['auth']], function () {
    Route::get('/', 'ClientController@overview')->name('client.overview');
    Route::get('/list', 'ClientController@listView')->name('client.list');
    Route::get('/create', 'ClientController@create')->name('client.create');
    Route::get('/show/{client}', 'ClientController@show')->name('client.show');
    Route::get('/edit/{client}', 'ClientController@edit')->name('client.edit');
    Route::post('/store', 'ClientController@store')->name('client.store');
    Route::post('/delete/{client}', 'ClientController@delete')->name('client.delete');
    Route::post('/update/{client}', 'ClientController@update')->name('client.update');
});

Route::group(['prefix' => 'group', 'middleware' => ['auth']], function () {
    Route::get('/', 'GroupController@overview')->name('group.overview');
    Route::get('/list', 'GroupController@listView')->name('group.list');
    Route::get('/create', 'GroupController@create')->name('group.create');
    Route::get('/show/{group}', 'GroupController@show')->name('group.show');
    Route::get('/edit/{group}', 'GroupController@edit')->name('group.edit');
    Route::post('/store', 'GroupController@store')->name('group.store');
    Route::post('/delete/{group}', 'GroupController@delete')->name('group.delete');
    Route::post('/update/{group}', 'GroupController@update')->name('group.update');
});
