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
    Route::get('results', [VoteController::class, 'results'])->name('results');
});

require __DIR__.'/auth.php';
