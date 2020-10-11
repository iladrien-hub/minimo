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

Route::get('/', ['as' => 'homepage', 'uses' => '\App\Http\Controllers\PageController@homepage']);
Route::get('/create-post', ['as' => 'newpost', 'uses' => '\App\Http\Controllers\PageController@newpost']);
Route::get('/admin', ['as' => 'admin', 'uses' => '\App\Http\Controllers\PageController@adminPanel']);
Route::get('/{id}', ['as' => 'post', 'uses' => '\App\Http\Controllers\PageController@post']);
Route::get('/update-post/{id}', ['as' => 'update', 'uses' => '\App\Http\Controllers\PageController@update']);
Route::get('/remove-post/{id}', ['as' => 'rempost', 'uses' => '\App\Http\Controllers\ContentController@removePost']);

Route::post('/create-post-commit', ['as' => 'create-post', 'uses' => '\App\Http\Controllers\ContentController@addPost']);
Route::post('/update-post-commit', ['as' => 'update-post', 'uses' => '\App\Http\Controllers\ContentController@updatePost']);
Route::post('/upload-image', ['as' => 'upload-image', 'uses' => '\App\Http\Controllers\ContentController@uploadImage']);
