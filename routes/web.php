<?php

Route::group(['middleware' => 'auth'], function() {

    Route::get('/','PostsController@index')->name('top');

    Route::resource('posts', 'PostsController', ['only' => ['create', 'store', 'show', 'edit', 'update', 'destroy']]);

    Route::resource('comments','CommentsController',['only' => ['store', 'edit', 'update', 'destroy']]);

});

Auth::routes();