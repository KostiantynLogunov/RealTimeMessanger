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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    $users = \App\User::select('email', 'id')->where('id', '!=', \Illuminate\Support\Facades\Auth::id())->get();
    $user = \Illuminate\Support\Facades\Auth::user();

    return view('welcome', [
        'users' => $users,
        'user' => $user,
    ]);
});
Route::get('/send-private-msg', 'StartController@sendPrivateMessage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
