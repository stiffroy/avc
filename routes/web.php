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

Route::prefix('client')->group(function () {
    Route::get('/', 'ClientController@overview')->name('client.overview');
    Route::get('/list', 'ClientController@listView')->name('client.list');
    Route::get('/create', 'ClientController@create')->name('client.create');
    Route::get('/show/{client}', 'ClientController@show')->name('client.show');
    Route::get('/edit/{client}', 'ClientController@edit')->name('client.edit');
    Route::post('/store', 'ClientController@store')->name('client.store');
    Route::post('/delete/{client}', 'ClientController@delete')->name('client.delete');
    Route::post('/update/{client}', 'ClientController@update')->name('client.update');
});
