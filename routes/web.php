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

// welcome
Route::get('/', function () {
    return view('welcome');
});

// admin
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('posts', 'AdminPostController');
    });

// guest
Route::get('/guest/posts', 'GuestPostController@index')->name('guest.posts.index');
Route::get('/guest/posts/post/{slug}', 'GuestPostController@show')->name('guest.posts.show');
