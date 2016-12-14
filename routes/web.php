<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
    //
});

Route::group(['prefix'=>'/user','as'=>'user:'],function(){
    Route::get('/login',function(){
        return view('user.login');
    })->name('login');
    Route::post('/login','UserController@login');
    Route::get('/logout',function(){
        Auth::logout();
    })->name('logout');
});

Route::group(['prefix'=>'/','middleware'=>'hasLogin'],function(){
    Route::get('/',function(){
        return view('index');
    })->name('index');
});

Route::group(['prefix'=>'/info','as'=>'info:','middleware'=>'hasLogin'],function(){
    Route::get('/department','InfoController@getDepartment')->name('department');
    Route::get('/speciality','InfoController@getSpeciality')->name('speciality');
    Route::get('/student',function(){
        //return view('index');
    })->name('student');
    Route::get('/teacher',function(){
        //return view('index');
    })->name('teacher');
    Route::get('/course',function(){
        //return view('index');
    })->name('course');
});
