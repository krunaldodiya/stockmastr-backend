<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/terms', 'HomeController@terms')->name('terms');

Route::get('/passport', 'HomeController@passport')->name('passport');

Route::group(['prefix' => 'payments'], function () {
    Route::get('/create-order', 'PaymentController@createOrder')->name('paytm.create-order');
    Route::post('/process-order', 'PaymentController@processOrder')->name('paytm.process-order');
    Route::post('/order-response', 'PaymentController@orderResponse')->name('paytm.order-response');
    Route::get('/order-status', 'PaymentController@orderStatus')->name('payments.order-status');
});