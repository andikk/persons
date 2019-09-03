<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@start');
Route::get('/list', 'IndexController@list');
Route::post('/store', 'IndexController@store');
Route::post('/delete/{person}', 'IndexController@delete');
Route::post('/update', 'IndexController@update');