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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('home');


Route::get('/fastwork/intro', function () {
    return view('fastwork/intro');
});



Route::middleware(['auth'])->group(function () {
    Route::resource('fastwork', 'FastworkController');
});

Route::resource('project', 'ProjectController');
Route::resource('project', 'ProjectController');