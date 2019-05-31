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
//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


//Pages Controller
Route::get('/dash', 'PagesController@dashboard');   //User Dashboard, guest ->login page
Route::get('/unauthorized', 'PagesController@unauthorized');
Route::get('/error', 'PagesController@error');
Route::get('/about', 'PagesController@about');  //About page
Route::get('/users', 'PagesController@users'); //List of users
Route::get('/myaccount', 'PagesController@myaccount');    // My account settings


//Elements
/*Route::resource('album','AlbumsController');
Route::resource('photo','PhotosController');
Route::resource('user','UsersController');
Route::get('/photo/upload/{album_id}','PhotosController@upload');*/


/*  Redirect any other queries
Route::any('{query}', 
  function() { return redirect('/'); })
  ->where('query', '.*');
*/