<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\blogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;



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

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('index',[PostController::class,'index'])->name('index');
Route::get('signup',[AuthController::class,'signupView'])->name('register');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::middleware(['login'])->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::post('/{id}/like', [PostController::class, 'likePost'])->name('posts.like');
        Route::post('/{id}/comment', [PostController::class, 'addComment'])->name('posts.comment');
        Route::get('/destroy/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::get('/edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
        Route::post('/update/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::post('/{post}/emailShare', [PostController::class, 'emailShare'])->name('posts.emailShare');

    });
    Route::post('/comment/{comment}/like', [PostController::class, 'likeComment'])->name('comment.like');
});


