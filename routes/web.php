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

// Admin
Route::get('/admin/{id}', ['as' => 'admin', 'uses' => '\App\Http\Controllers\PageController@adminPanel']);
Route::get('/remove-post/{id}', ['as' => 'rempost', 'uses' => '\App\Http\Controllers\ContentController@removePage']);
Route::get('/update-post/{id}', ['as' => 'update', 'uses' => '\App\Http\Controllers\PageController@update']);
Route::get('/create-post/{id}', ['as' => 'newpost', 'uses' => '\App\Http\Controllers\PageController@newpost']);



Route::post('/add-category', ['as' => 'add-category', 'uses' => '\App\Http\Controllers\ContentController@categoryControl']);

Route::post('/get-pages-like', ['as' => 'get-pages-like', 'uses' => '\App\Http\Controllers\PageController@getPagesLike']);
Route::post('/add-alias', ['as' => 'add-alias', 'uses' => '\App\Http\Controllers\ContentController@addAlias']);
Route::post('/update-alias', ['as' => 'update-alias', 'uses' => '\App\Http\Controllers\ContentController@updateAlias']);

Route::post('/create-post-commit', ['as' => 'create-post', 'uses' => '\App\Http\Controllers\ContentController@addPost']);
Route::post('/update-post-commit', ['as' => 'update-post', 'uses' => '\App\Http\Controllers\ContentController@updatePost']);
Route::post('/upload-image', ['as' => 'upload-image', 'uses' => '\App\Http\Controllers\ContentController@uploadImage']);

// View
Route::get('/', ['as' => 'homepage', 'uses' => '\App\Http\Controllers\PageController@homepage']);
Route::get('/{id}', ['as' => 'page', 'uses' => '\App\Http\Controllers\PageController@page']);
