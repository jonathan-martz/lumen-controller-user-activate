<?php

use Illuminate\Support\Facades\Route;

Route::post('/user/activate', [
    'middleware' => ['xss', 'https'],
    'uses' => 'App\Http\Controllers\UserActivateController@activate'
]);
