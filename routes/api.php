<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Retruns details of Current authorized user
Route::get('/details', 'Api\PassportController@details')->middleware('auth:api');


//Login and Register
Route::post('/login', 'Api\PassportController@login');
Route::post('/register', 'Api\PassportController@register');

//Users
Route::get('/users','Api\UserController@index');    //returns list of users
Route::post('/users','Api\UserController@store');   //creates new user


Route::group(['middleware' => 'auth:api'], function(){  //Authenticated only

    //Users
    Route::put('/users/{id}','Api\UserController@update'); //update user with id
    Route::delete('/users/{id}','Api\USerController@destroy'); //delele user with id

    //Albums
    Route::post('/albums','Api\AlbumController@store');   //create new album
    Route::put('/albums/{id}','Api\AlbumController@update'); //update album with id
    Route::delete('/albums/{id}','Api\AlbumController@destroy'); //delele album with id


    //Photos
    Route::post('/photos','Api\PhotoController@store');   //upload new photo
    Route::put('/photos/{id}','Api\PhotoController@update'); //update photo with id
    Route::delete('/photos/{id}','Api\PhotoController@destroy'); //delele photo with id
});


//Allows both guest and auth access
$middleware = ['api'];
if (\Request::header('Authorization')) 
   $middleware = array_merge(['auth:api']);
Route::group(['middleware' => $middleware], function () {
    
    Route::get('/users/{id}', 'Api\UserController@show');   //with auth -> return all albums, guest-> return only public albums
    Route::get('/albums/{id}', 'Api\AlbumController@show'); //with auth -> return all photos, guest-> return only public photos
    Route::get('/photos/{id}', 'Api\PhotoController@show'); //with auth -> access private photo

});





