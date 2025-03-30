<?php

use Illuminate\Support\Facades\Route;


Route::get('token')
    ->name('get_token')
    ->uses('ApiUserController@getToken');

Route::post('users')
    ->name('create_user')
    ->uses('ApiUserController@createUser')
    ->middleware('token.auth');

Route::get('/users/{id}')
    ->name('get_user')
    ->uses('ApiUserController@getUser')
    ->whereNumber('id');

Route::get('users')
    ->name('index_user')
    ->uses('ApiUserController@indexUsers');

Route::get('positions')
    ->name('index_positions')
    ->uses('ApiUserController@indexPositions');
