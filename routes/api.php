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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::group([
    'middleware' => 'auth:api'
], function () {

    Route::group(['prefix' => 'checklists'], function () {
        Route::post('/complete', 'ItemController@complete');
        Route::post('/incomplete', 'ItemController@incomplete');
        Route::get('/items/summaries', 'ItemController@summaries');

        Route::get('/histories', 'ItemController@show');
        Route::get('/histories/{history}', 'ItemController@show');
        Route::get('/items', 'ItemController@index');

        Route::get('/templates', 'TemplateController@index');
        Route::post('/templates', 'TemplateController@store');
        //Templates
        Route::prefix('templates')->group(function () {
            Route::get('/{template}', 'TemplateController@show');
            Route::patch('/{template}', 'TemplateController@update');
            Route::delete('/{template}', 'TemplateController@destroy');
        });

        Route::get('/{checklist}/items', 'ChecklistController@items');
        Route::get('/{checklist}/items/{item}', 'ChecklistController@item');
        Route::post('/{checklist}/items', 'ItemController@store');
        Route::patch('/{checklist}/items/{item}', 'ItemController@update');
        Route::delete('/{checklist}/items/{item}', 'ItemController@destroy');
        Route::post('/{checklist}/items/_bulk', 'ItemController@store_bulk');
    });

    Route::resource('checklists', 'ChecklistController');
});
