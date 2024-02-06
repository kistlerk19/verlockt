<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/profile-image', [ProfileController::class, 'updateProfileImage'])
        ->name('profile.image.update');

    Route::post('post', [PostController::class, 'store'])->name('post.create');
    Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::get('posts/download/{attachment}', [PostController::class, 'download'])
        ->name('post.download');

    Route::post('posts/{post}/reaction', [PostController::class, 'postReaction'])
        ->name('post.reaction');

    Route::post('posts/{post}/comment', [PostController::class, 'createComment'])
        ->name('post.comment.create');
});

require __DIR__ . '/auth.php';
