<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // main routes

    // "mark as done" route
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');

    // tasks route
    Route::resource('tasks', TaskController::class);

    // route for comments
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

    // project route
    Route::resource('projects', ProjectController::class)->middleware('can:assignUser');

    // admin panel routes
    Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::patch('users/{user}/block', [UserController::class, 'block'])->name('users.block');
        Route::patch('users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
        Route::get('statistics', [AdminController::class, 'statistics'])->name('statistics');
    });

    
});

require __DIR__.'/auth.php';
