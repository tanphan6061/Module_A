<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::resource('events', 'EventController')->middleware(['auth', 'check']);
Route::group(['prefix' => 'events/{event}', 'middleware' => ['auth', 'check']], function () {
    Route::resource('sessions', 'SessionController');
    Route::resource('rooms', 'RoomController');
    Route::resource('channels', 'ChannelController');
    Route::resource('tickets', 'TicketController');
    Route::get('report', 'EventController@report')->name('events.report');
});
