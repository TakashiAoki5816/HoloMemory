<?php
//ルート
Route::get('/','MainController@main')->name('root');

Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
    Route::get('/request','MainController@request')->name('request');
});

