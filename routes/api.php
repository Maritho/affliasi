<?php

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'Apis\AuthController@login');
    Route::post('logout', 'Apis\AuthController@logout');
    Route::post('refresh', 'Apis\AuthController@refresh');
    Route::post('register', 'Apis\AuthController@register');
    Route::get('me', 'Apis\AuthController@me');
    Route::put('rekening', 'Apis\AuthController@rekening');
    Route::get('blogger', 'Apis\AuthController@blogger');
    Route::delete('blogger/{id}', 'Apis\AuthController@blogger_delete');
    Route::put('change-status/{id}', 'Apis\AuthController@change_status');
});

Route::group(['prefix' => 'transaction'], function ($router) {
    Route::get('all', 'Apis\TransactionController@getTansaction');
    Route::get('tracking', 'Apis\TransactionController@tracking');
    Route::post('callback', 'Apis\TransactionController@callback');
});

Route::group(['prefix' => 'penarikan'], function ($router) {
    Route::post('/', 'Apis\PenarikanController@penarikan');
    Route::get('all', 'Apis\PenarikanController@all');
    Route::get('detail/{id}', 'Apis\PenarikanController@detail');
    Route::put('change-status/{id}', 'Apis\PenarikanController@change_status');
});

Route::group(['prefix' => 'campaign'], function ($router) {
    Route::get('ads', 'Apis\CampaignController@publicCampaign');
    Route::get('all', 'Apis\CampaignController@all');
    Route::post('add', 'Apis\CampaignController@add');
    Route::post('update', 'Apis\CampaignController@update');
    Route::delete('{id}', 'Apis\CampaignController@delete');
    Route::get('detail/{id}', 'Apis\CampaignController@detail');
});

Route::group(['prefix' => 'invoice'], function ($router) {
    Route::get('{id}', 'Apis\PenarikanController@invoice');
});
