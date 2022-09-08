<?php

use Illuminate\Http\Request;

Route::get('/', 'MainController@main')->name('root');

/**********************************
 * ログイン処理
 **********************************/
Auth::routes();
Route::get('/user', function (Request $request) {
    $user = $request->user();
    return response()->json($user);
});

/**********************************
 * メンバー
 **********************************/
Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
    Route::get('/index', 'MembersController@index')->name('index');
});
