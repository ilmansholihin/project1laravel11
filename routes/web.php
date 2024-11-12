<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ListController;

// Route::get('/', [ListController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\http\Controllers\Admin\ProductController;
use App\http\Controllers\User\UserController;

// Guest Route
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');

    Route::post('/post-login', [AuthController::class, 'login'])
        ->middleware('guest');
});

// Admin Route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // produc Route
    // index sebelumnya adalah dashboard
    Route::get('/product',[ProductController::class, 'index'])->name('admin.product');

    // Route::get('/admin', function () {
    //     return view('pages.admin.index');
    // })->name('admin.dashboard');

    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])
        ->name('admin.logout')
        ->middleware('admin');
});

// User Route
Route::group(['middleware' => 'web'], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    // Route::get('/user', function () {
    //     return view('pages.user.index');
    // })->name('user.dashboard');

    Route::get('/user-logout', [AuthController::class, 'user_logout'])
        ->name('user.logout')
        ->middleware('web');
});
