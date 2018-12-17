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
    return view('home');
})->name('home');

Auth::routes();

Route::middleware([
    'auth'
])->group(function () {
    Route::view('/my-account', 'accounts.profile')
        ->name('profile');

    Route::get('/users', 'UserController@index')
        ->name('users');
    Route::get('/roles', 'RoleController@index')
        ->name('roles');
});

Route::get('/dashboard', 'DashboardController@index')
    ->name('dashboard');
