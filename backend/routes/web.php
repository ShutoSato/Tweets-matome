<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'SearchController@search')->name('search');

Route::post('/executePython', 'PythonController@executePython')->name('executePython');

Route::get('/result/{searchWord}', 'ShowController@showResult')->name('showResult');

Route::get('/result/{searchWord}/showAllTweets', 'ShowController@showAllTweets')->name('showAllTweets');

Route::get('/result/{searchWord}/showPositiveTweets', 'ShowController@showPositiveTweets')->name('showPositiveTweets');

Route::get('/result/{searchWord}/showNeutralTweets', 'ShowController@showNeutralTweets')->name('showNeutralTweets');

Route::get('/result/{searchWord}/showNegativeTweets', 'ShowController@showNegativeTweets')->name('showNegativeTweets');

Route::get('/result/{searchWord}/showWordRank', 'ShowController@showWordRank')->name('showWordRank');

Route::get('/result/{searchWord}/showPositiveWordRank', 'ShowController@showPositiveWordRank')->name('showPositiveWordRank');

Route::get('/result/{searchWord}/showNeutralWordRank', 'ShowController@showNeutralWordRank')->name('showNeutralWordRank');

Route::get('/result/{searchWord}/showNegativeWordRank', 'ShowController@showNegativeWordRank')->name('showNegativeWordRank');

