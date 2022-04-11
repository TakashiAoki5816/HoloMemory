<?php
Route::get('/', 'MainController@main')->name('root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
