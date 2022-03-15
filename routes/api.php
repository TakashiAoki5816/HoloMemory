<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    Route::get('/videos', 'Api\YoutubeController@index')->name('videos.index');
    Route::get('/videos/create', 'Api\YoutubeController@store')->name('videos.create');
});
