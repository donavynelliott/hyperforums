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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{id?}', 'UserController@show')->name('profile');

//Forums
Route::get('/forum', 'ThreadController@index')->name('forum');
Route::get('/forum/{thread}', 'ThreadController@show')->name('forum.show');


Route::resource('threads', 'ThreadController')->middleware('auth');
Route::post('/threads/{thread}/replies', 'ReplyController@store')->middleware('auth');