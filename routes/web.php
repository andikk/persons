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


Route::get('/', 'IndexController@index');
Route::get('page/add', 'IndexController@add')->name('personAdd');
Route::post('page/add', 'IndexController@store')->name('personStore');
Route::delete('/delete/{person}', 'IndexController@delete')->name('personDelete');
Route::post('/edit', 'IndexController@edit')->name('personEdit');
Route::post('/update', 'IndexController@update')->name('personUpdate');
