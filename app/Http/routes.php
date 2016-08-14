<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('/register', 'Auth\RegisterController@register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('/my/users', 'ControlCenter\UserController');
    Route::resource('/activity', 'Activity\ActivityController');
    Route::resource('user.league', 'ControlCenter\UserLeagueController');
});

