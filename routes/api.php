<?php

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'Apis\AuthController@login');
    Route::post('logout', 'Apis\AuthController@logout');
    Route::post('refresh', 'Apis\AuthController@refresh');
    Route::post('register', 'Apis\AuthController@register');
    Route::get('me', 'Apis\AuthController@me');
});
