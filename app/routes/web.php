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
})
	->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@index')->middleware('auth')->name('profile');
Route::get('/profile/{id}', 'UserController@show')->name('profile.show');

//Forums
Route::get('/forum', 'ForumController@index')->name('forum');
Route::get('/forum/{forum}', 'ForumController@show')->name('forum.show');

Route::get('/forum/{forum}/threads/create', 'ThreadController@create')->name('forum.addthread')
		->middleware('auth');
Route::resource('threads', 'ThreadController')->middleware('auth');

//resource rewrites
Route::get('/forum/{forum}/threads/{thread}', 'ThreadController@show')->name('threads.show');

//reply doesn't need whole controller
Route::post('/forum/{forum}/threads/{thread}/replies', 'ReplyController@store')
		->middleware('auth')
		->name('replies.store');
Route::post('/forum/{forum}/threads/store', 'ThreadController@store')
		->middleware('auth');
