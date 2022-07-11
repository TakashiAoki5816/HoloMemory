<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    Route::get('/groups', 'Api\GroupController@index')->name('groups.index');

    Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
        Route::get('', 'Api\YoutubeController@index')->name('index');
        Route::get('/jp', 'Api\YoutubeController@jp')->name('jp');
        Route::get('/en', 'Api\YoutubeController@en')->name('en');
        Route::get('/id', 'Api\YoutubeController@id')->name('id');
        Route::get('/create', 'Api\YoutubeController@store')->name('create');
    });

    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::get('/index', 'Api\MemberController@index')->name('index');
    });
});
