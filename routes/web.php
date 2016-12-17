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
Route::group(['prefix'=>'/','middleware'=>'hasLogin'],function(){
    Route::get('/',function(){
        return view('index');
    })->name('index');
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

Route::group(['prefix'=>'/info','as'=>'info:','middleware'=>'hasLogin'],function(){
    Route::get('/department','InfoController@getDepartment')->name('department');
    Route::post('/department','InfoController@postDepartment');
    Route::delete('/department/{id}','InfoController@deleteDepartment');
    Route::get('/speciality','InfoController@getSpeciality')->name('speciality');
    Route::post('/speciality','InfoController@postSpeciality');
    Route::delete('/speciality/{id}','InfoController@deleteSpeciality');
    Route::get('/student','InfoController@getStudent')->name('student');
    Route::post('/student','InfoController@postStudent');
    Route::delete('/student/{id}','InfoController@deleteStudent');

    Route::get('/teacher',function(){
        //return view('index');
    })->name('teacher');
    Route::get('/course',function(){
        //return view('index');
    })->name('course');
});
