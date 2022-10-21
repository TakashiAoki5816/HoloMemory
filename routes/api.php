<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    // Route::middleware(['middleware' => 'api'])->group(function () {
    //**********************************
    // グループ（JP, EN, ID）
    //**********************************
    Route::get('/groups', 'Api\GroupController@index')->name('groups.index');

    //**********************************
    // 配信情報
    //**********************************
    Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
        Route::get('', 'Api\StreamsController@index')->name('index');
        Route::get('/date/index', 'Api\StreamsController@date_index')->name('date_index');
        Route::get('/create', 'Api\StreamsController@store')->name('create');
    });

    //**********************************
    // メンバー
    //**********************************
    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::get('/', 'Api\MembersController@index')->name('index');
    });
    // });
});
