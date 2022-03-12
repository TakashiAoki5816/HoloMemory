<?php
Route::middleware(['middleware' => 'api'])->group(function () {
    Route::get('/videos', 'YoutubeController@index')->name('videos.index');
    Route::get('/videos/create', 'YoutubeController@store')->name('videos.create');
});
