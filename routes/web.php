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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

//Topics
Route::get('/', 'TopicController@index')->name('topics.index');
Route::get('/topics.show/{id}', 'TopicController@show')->name('topics.show');
Route::get('/topics.edit/{id}', 'TopicController@edit')->name('topics.edit');
Route::post('/topics.update/{id}', 'TopicController@update')->name('topics.update');
Route::get('/topics.create', 'TopicController@create')->name('topics.create');
Route::post('/topics.store', 'TopicController@store')->name('topics.store');
Route::get('/topics.delete/{id}', 'TopicController@delete')->name('topics.delete');

Route::get('showFromNotification/{topic}/{notification}', 'TopicController@showFromNotification')->name('topics.showFromNotification');

//Comments
Route::post('/comments/{topic}', 'CommentController@store')->name('comments.store');
Route::post('/mark-as-solution','TopicController@markAsSolution')->name('markAsSolution');
Route::post('/markedAsSolution/{topic}/{comment}', 'CommentController@markedAsSolution')->name('comments.markedAsSolution');

//Reply
Route::post('/commentReply/{comment}', 'CommentController@storeCommentReply')->name('comments.storeReply');
});


