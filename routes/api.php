<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('news/archive/{news}', 'NewsController@archive');
Route::get('news/restore/{news}', 'NewsController@restore');

Route::resource('news', 'NewsController', ['only' => [
    'index', 'store', 'update'
]]);
