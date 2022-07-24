<?php

use Illuminate\Http\Request;

Route::get('/', 'MainController@main')->name('root');

Auth::routes();
Route::get('/user', function (Request $request) {
    $user = $request->user();
    return response()->json($user);
});

Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
    Route::get('/index', 'MembersController@index')->name('index');
});
