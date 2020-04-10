<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::resource('task_statuses', 'TaskStatusController');
Route::resource('tasks', 'TaskController');
