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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => 'auth.api'], function () {

    Route::match(['get', 'put', 'delete', 'patch'], '/spacecraft/add', function () {
        return response()->json(['message' => 'Not Found!'], 404);
    });
    Route::post('/spacecraft/add', 'V1\SpacecraftController@setSpacecraft');

    Route::match(['post', 'put', 'delete', 'patch'], '/spacecrafts', function () {
        return response()->json(['message' => 'Not Found!'], 404);
    });
    Route::get('/spacecrafts', 'V1\SpacecraftController@getSpacecrafts');

    Route::match(['post', 'put', 'delete', 'patch'], '/spacecraft/id/{id}', function () {
        return response()->json(['message' => 'Not Found!'], 404);
    })->where('id', '[0-9]+');
    Route::get('/spacecraft/id/{id}', 'V1\SpacecraftController@getSpacecraftById')->where('id', '[0-9]+');

    Route::match(['get', 'post', 'delete', 'patch'], '/spacecraft/edit/{id}', function () {
        return response()->json(['message' => 'Not Found!'], 404);
    })->where('id', '[0-9]+');
    Route::put('/spacecraft/edit/{id}', 'V1\SpacecraftController@editSpacecraft')->where('id', '[0-9]+');

    Route::match(['get', 'post', 'get', 'patch'], '/spacecraft/delete/{id}', function () {
        return response()->json(['message' => 'Not Found!'], 404);
    })->where('id', '[0-9]+');
    Route::delete('/spacecraft/delete/{id}', 'V1\SpacecraftController@deleteSpacecraft')->where('id', '[0-9]+');

});