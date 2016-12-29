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
use Illuminate\Contracts\Auth\Guard;

Route::pattern('id','\d+');

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
        Auth::guard(request()->guard_name)->logout();
        return redirect()->route('user:login');
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
    Route::put('/student','InfoController@resetStudentPassword');
    Route::get('/teacher','InfoController@getTeacher')->name('teacher');
    Route::post('/teacher','InfoController@postTeacher');
    Route::delete('/teacher/{id}','InfoController@deleteTeacher');
    Route::put('/teacher','InfoController@resetTeacherPassword');
    Route::get('/course','InfoController@getCourse')->name('course');
    Route::post('/course','InfoController@postCourse');
    Route::delete('/course/{id}','InfoController@deleteCourse');
});

Route::group(['prefix'=>'/course','as'=>'course:','middleware'=>'hasLogin'],function(){
    Route::get('/choose','CourseController@getChoose')->name('choose');
    Route::get('/student','CourseController@getStudent')->name('student');
    Route::post('/choose','CourseController@postChoose');
    Route::get('/management','CourseController@getManagement')->name('management');
    Route::get('/management/{student_id}/{course_id}','CourseController@dismissStudent')->name('dismiss');
});

Route::group(['prefix'=>'/teacher','as'=>'teacher:','middleware'=>'hasLogin'],function(){

});
