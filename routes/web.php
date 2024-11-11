<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;

Route::get('/', [ListController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });
