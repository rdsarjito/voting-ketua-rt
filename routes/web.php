<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\VoteController;

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

    // User voting routes
    Route::get('/categories', [VoteController::class, 'categories'])->name('vote.categories');
    Route::get('/categories/{category}', [VoteController::class, 'showCategory'])->name('vote.category.show');
    Route::post('/vote/{candidate}', [VoteController::class, 'store'])->name('vote.store');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('candidates', CandidateController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('results', [VoteController::class, 'results'])->name('results');
    Route::get('results/export', [VoteController::class, 'exportResults'])->name('results.export');
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('emails', [\App\Http\Controllers\Admin\EmailController::class, 'index'])->name('emails.index');
    Route::post('emails/reminder', [\App\Http\Controllers\Admin\EmailController::class, 'sendReminder'])->name('emails.reminder');
    Route::post('emails/results', [\App\Http\Controllers\Admin\EmailController::class, 'sendResults'])->name('emails.results');
});

require __DIR__.'/auth.php';
