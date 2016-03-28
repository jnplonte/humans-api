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

Route::group(['middleware' => ['humansApi']], function () {

    Route::get('/', function () {
        return abort(404);
    });

    Route::get('humans', [
        'as' => 'human', 'uses' => 'HumansController@getAll'
    ]);

    Route::post('human', [
        'as' => 'human', 'uses' => 'HumansController@insert'
    ]);

    Route::get('human/{id}', [
        'as' => 'human', 'uses' => 'HumansController@get'
    ])->where('id', '[0-9]+');

    Route::match(['put', 'delete'], 'human/{id}', [
        'as' => 'human', 'uses' => 'HumansController@update'
    ])->where('id', '[0-9]+');
});
