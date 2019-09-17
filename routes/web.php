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

// Auth routes.
Auth::routes();

// Basic home route.
Route::get('/home', 'HomeController@index')->name('home');

// Social routes.
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->where('provider', 'google|github')->name('social.auth.redirect');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('provider', 'google|github')->name('social.auth.callback');

// Profile routes.

// Admin routes.
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::resource('role', 'RolesController')->except([
        'show', 'edit', 'update',
    ]);
    Route::resource('user', 'UsersController')->except([
        'create', 'store',
    ]);
});
