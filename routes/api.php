<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    //**********************************
    // グループ（JP, EN, ID）
    //**********************************
    Route::get('/groups', 'Api\GroupController@index')->name('groups.index');

    //**********************************
    // 配信情報
    //**********************************
    Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
        Route::get('', 'Api\YoutubeController@index')->name('index');
        Route::get('/jp', 'Api\YoutubeController@jp')->name('jp');
        Route::get('/en', 'Api\YoutubeController@en')->name('en');
        Route::get('/id', 'Api\YoutubeController@id')->name('id');
        Route::get('/create', 'Api\YoutubeController@store')->name('create');
    });

    //**********************************
    // メンバー
    //**********************************
    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::get('/index', 'Api\MembersController@index')->name('index');
        Route::get('/jp', 'Api\MembersController@fetchJp')->name('jp');
        Route::get('/en', 'Api\MembersController@fetchEn')->name('en');
        Route::get('/id', 'Api\MembersController@fetchId')->name('id');
    });
});
