<?php

//$stripe1 = App::make('App\Billing\Stripe');
//$stripe2 = resolve('App\Billing\Stripe');
//$stripe3 = app('App\Billing\Stripe');
//dd($stripe1, $stripe2, $stripe3);

Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');
Route::get('/', 'PostsController@index')->name('home');
Route::get('/posts', 'PostsController@index');
Route::get('/posts/create', 'PostsController@create');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{post}', 'PostsController@show');

Route::get('/posts/tags/{tag}', 'TagsController@index');

Route::post('/post/{post}/comments', 'CommentsController@store');

Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');