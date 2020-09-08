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



Auth::routes();
Route::resource('users', 'UserController');
Route::middleware('superRole')->group(function (){


    Route::resource('roles', 'RoleController');

    Route::resource('permissions', 'PermissionController');
});

Route::get('/', function (){
    return view('home');
})->name('home');

Route::post('myApi/department','ApiController@department');

Route::resource('posts', 'PostController');

Route::resource('papers', 'PaperController');

Route::resource('resources', 'ResourceController');

Route::resource('informations', 'InformationController');

Route::resource('photos', 'PhotoController');

Route::resource('labbooks', 'LabBookController');

Route::get('/test','PermissionController@getName');

Route::get('student/lab','StudentController@lab');

Route::get('student/index','StudentController@index');

Route::get('student/show/{email}','StudentController@jump');

Route::post('upload','UploadFileController@upload')->name('upload');

Route::get('resource/search','ResourceController@search');

Route::get('labbook/search','LabBookController@search');


Route::get('time',function (){
  return view('welcome');
});

Route::get('prize/prize','PrizeController@index');