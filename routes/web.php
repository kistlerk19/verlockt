<?php

use App\Http\Controllers\GroupController;
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
Route::get('/g/{group:slug}', [GroupController::class, 'groupInfo'])->name('group.info');
Route::get('group/accept-invite/{token}', [GroupController::class, 'acceptInvitation'])
            ->name('group.accept.invite');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/profile-image', [ProfileController::class, 'updateProfileImage'])
        ->name('profile.image.update');

        // Posts
        Route::post('post', [PostController::class, 'store'])->name('post.create');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.delete');
        Route::get('posts/download/{attachment}', [PostController::class, 'download'])
        ->name('post.download');
        Route::post('posts/{post}/reaction', [PostController::class, 'postReaction'])
        ->name('post.reaction');

        // Comments
        Route::post('posts/{post}/comment', [PostController::class, 'createComment'])
        ->name('post.comment.create');
        Route::delete('comment/{comment}', [PostController::class, 'deleteComment'])
        ->name('comment.delete');
        Route::put('comment/{comment}', [PostController::class, 'updateComment'])
        ->name('comment.update');
        Route::post('comment/{comment}/impression', [PostController::class, 'commentImpression'])
        ->name('comment.impression');

        // Groups
        Route::post('group', [GroupController::class, 'store'])
            ->name('group.create');
        Route::put('group/{group:slug}', [GroupController::class, 'update'])
            ->name('group.update');
        Route::post('group/profile-image/{group:slug}', [GroupController::class, 'updateGroupImage'])
            ->name('group.image.update');
        Route::post('group/invite/{group:slug}', [GroupController::class, 'inviteUsers'])
            ->name('group.invite.user');
        Route::post('group/join/{group:slug}', [GroupController::class, 'join'])
            ->name('group.join');
        Route::post('group/approve-request/{group:slug}', [GroupController::class, 'approveRequest'])
            ->name('group.approveRequest');
        Route::post('group/role-change/{group:slug}', [GroupController::class, 'roleChange'])
            ->name('group.role.change');
        Route::delete('group/remove-user/{group:slug}', [GroupController::class, 'removeUser'])
                ->name('group.removeUser');

});

require __DIR__ . '/auth.php';
