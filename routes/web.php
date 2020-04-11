<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::resource('/', 'HomeController')->only('index');
Route::resource('task_statuses', 'TaskStatusController');
Route::resource('tasks', 'TaskController');
Route::resource('labels', 'LabelController');
