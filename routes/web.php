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

Route::get('/', 'HomeController@index');


// Login && Register
Route::get('/login', 'PublicController@login');
Route::post('/doLogin', 'PublicController@doLogin');
Route::get('/register', 'PublicController@register');
Route::post('/doRegister', 'PublicController@doRegister');
Route::post('/logout', 'PublicController@logout');

