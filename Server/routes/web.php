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

Route::resource('/api/token', 'TokensController');

Route::resource('/api/login', 'LoginsController');

Route::resource('/api/profile', 'ProfileController');

Route::resource('/api/classes', 'ClassesController');

Route::resource('/api/courses', 'CoursesController');

Route::resource('/api/sheetsquizzs', 'SheetsQuizzsController');
