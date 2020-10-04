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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'api\AttendeeController@login');
    Route::post('logout', 'api\AttendeeController@logout');
    Route::get('events', 'api\EventController@index');
    Route::get('organizers/{oSlug}/events/{eSlug}', 'api\EventController@show');
    Route::post('organizers/{oSlug}/events/{eSlug}/registration', 'api\EventController@registrationEvent');
    Route::get('registrations', 'api\EventController@registrations');
});
