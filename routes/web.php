<?php

Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');
Route::get('/posts', 'PostsController@index');
Route::get('/posts/{post}', 'PostsController@show');