<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now csreate something great!
|
*/

//PUBLIC ROUTES 

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/fastwork/intro', function () {
    return view('fastwork/intro');
});

//AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {
    Route::resource('fastwork', 'FastworkController');
    Route::get('/user/{id}', 'UserController@show');
    Route::resource('project', 'ProjectController');
    Route::resource('profile', 'ProfileController');
});


Route::get('/vision', function () {
    return view('vision');
});