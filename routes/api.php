<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    Route::group(['as' => 'videos.'], function () {
        Route::get('/videos', 'Api\YoutubeController@index')->name('index');
        Route::get('/videos/jp', 'Api\YoutubeController@jp')->name('jp');
        Route::get('/videos/en', 'Api\YoutubeController@en')->name('en');
        Route::get('/videos/id', 'Api\YoutubeController@id')->name('id');
        Route::get('/videos/create', 'Api\YoutubeController@store')->name('create');
    });

    Route::get('/groups', 'Api\GroupController@index')->name('groups.index');
});
