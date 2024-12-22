<?php

use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Auth::routes(['verify' => true]);

Route::view('/', 'welcome');

//Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/documents', [AdminController::class, 'documents'])->name('admin.documents');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.partials.profile');
});

//Reviewer routes
Route::prefix('reviewer')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('reviewer.partials.dashboard');
    //Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    //Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    //Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/documents', [ReviewerController::class, 'documentsReview'])->name('reviewer.partials.documents');
    Route::get('/assessment', [ReviewerController::class, 'assessment'])->name('reviewer.partials.assessment');
    Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.partials.reviewed');
    Route::get('/profile', [ReviewerController::class, 'profile'])->name('reviewer.partials.profile');
});
//User routes
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/submit', [UserController::class, 'submit'])->name('user.submit');
    //Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    //Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    //Route::get('/documents', [ReviewerController::class, 'documentsReview'])->name('reviewer.partials.documents');
    //Route::get('/assessment', [ReviewerController::class, 'assessment'])->name('reviewer.partials.assessment');
    //Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.partials.reviewed');
    Route::get('/profile', [UserController::class, 'profile'])->name('reviewer.profile');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Additional routes for authentication (if any)
require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');