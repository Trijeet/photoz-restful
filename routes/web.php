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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::get('/about','Web\PageController@about');

//Route::get('/unauth','Web\PageController@unauth');
//Route::get('/error','Web\PageController@error');
//Route::get('/success','Web\PageController@success');


Route::post('/register','Web\UserController@register')->middleware('guest');
Route::post('/login','Web\UserController@login')->middleware('guest');

Route::get('/users', 'Web\UserController@index');
Route::get('/myaccount', 'Web\UserController@myaccount')->middleware('auth');

Route::get('/users/{id}','Web\UserController@show');
Route::delete('/users/{id}','Web\UserController@delete')->middleware('auth');
Route::get('/users/{id}/edit','Web\UserController@edituser')->middleware('auth');
Route::put('/users/{id}','Web\UserController@edit')->middleware('auth');

Route::get('/albums/create','Web\AlbumController@createalbum')->middleware('auth');
Route::post('/albums','Web\AlbumController@create')->middleware('auth');
Route::get('/albums/{id}/edit','Web\AlbumController@editalbum')->middleware('auth');
Route::put('/albums/{id}','Web\AlbumController@edit')->middleware('auth');
Route::get('/albums/{id}','Web\AlbumController@show');
Route::delete('/albums/{id}','Web\AlbumController@delete')->middleware('auth');

Route::get('/photos/upload/{id}','Web\PhotoController@upload')->middleware('auth');
Route::post('/photos','Web\PhotoController@create')->middleware('auth');
Route::get('/photos/{id}/edit','Web\PhotoController@editphoto')->middleware('auth');
Route::put('/photos/{id}','Web\PhotoController@edit')->middleware('auth');
Route::get('/photos/{id}','Web\PhotoController@show');
Route::delete('/photos/{id}','Web\PhotoController@delete')->middleware('auth');


//Likes
Route::put('/albums/{id}/like','Web\AlbumController@like')->middleware('auth');
Route::put('/albums/{id}/unlike','Web\AlbumController@unlike')->middleware('auth');

Route::put('/photos/{id}/like','Web\PhotoController@like')->middleware('auth');
Route::put('/photos/{id}/unlike','Web\PhotoController@unlike')->middleware('auth');