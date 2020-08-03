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
    return view('home');
    //return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/fastwork/intro', function () {
    return view('fastwork/intro');
});

Route::get('/simulation', function () {
    return view('simulation');
});
Route::resource('ocr', 'OcrController');
Route::resource('fastwork-status', 'FastworkStatusController');

//AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {   

    //ADMIN ONLY
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('fastwork', 'FastworkController')->except(['index','show','update']); 
        Route::resource('payment', 'PaymentController')->except(['index','show']); 
        Route::resource('profile', 'ProfileController')->except(['index','show','edit','update']);
        Route::resource('project', 'ProjectController')->except(['index','show']);        
        Route::resource('user', 'UserController')->except(['show']);
        Route::resource('income', 'IncomeController');
    });
    //USER AND ADMIN
    Route::middleware(['role:admin,user,developer'])->group(function () {        
        Route::resource('fastwork', 'FastworkController')->only(['index','show','update']);         
        Route::resource('payment', 'PaymentController')->only(['index','show']); 
        Route::resource('profile', 'ProfileController')->only(['index','show','edit','update']);        
        Route::resource('project', 'ProjectController')->only(['index','show']);        
        Route::resource('user', 'UserController')->only(['show']);
    });
    
});
use Intervention\Image\ImageManagerStatic as Image;


Route::get('/img', function()
{
    $img = Image::make(url('/foo.jpg'))->resize(300, 200);

    return $img->response('jpg');
});

Route::resource('my-log', 'MyLogController');
Route::resource('location', 'LocationController');
Route::resource('staffgauge', 'StaffgaugeController');