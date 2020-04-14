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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::redirect('/', '/contacts');
Route::view('/contacts', 'contacts');
Route::view('/contacts/show', 'contacts', ['action' => 'show']);
Route::view('/contacts/add', 'contacts', ['action' => 'add']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
