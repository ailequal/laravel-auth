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

// auth
Auth::routes();

// admin
Route::get('/home', 'HomeController@index')->name('home');
Route::name('admin.')
    ->prefix('admin')
    ->middleware('auth')
    ->group(function () {
        // admin.posts
        Route::resource('posts', 'AdminPostController');
        // admin.tags
        // Route::post('/tags', 'AdminTagController@store')->name('tags.store');
        // Route::post('/tags/{slug}', 'AdminTagController@update')->name('tags.update');
    });

// guest.posts
Route::get('/guest/posts', 'GuestPostController@index')->name('guest.posts.index');
Route::get('/guest/posts/{slug}', 'GuestPostController@show')->name('guest.posts.show');
// guest.comments
Route::post('/guest/comments', 'GuestCommentController@store')->name('guest.comments.store');
