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

Route::get('/', array('as'=>'search', 'uses' => 'WebController@showIndex'));
Route::get('admin/set-urdu', ['as' => 'set-urdu', 'uses' => 'WebController@setUrdu']);
Route::get('admin/set-english', ['as' => 'set-english', 'uses' => 'WebController@setEnglish']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
