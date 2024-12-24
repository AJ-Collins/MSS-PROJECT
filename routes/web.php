<?php

use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbstractSubmissionController;
use App\Http\Controllers\ResearchSubmissionController;

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
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/documents', [UserController::class, 'documents'])->name('user.documents');
    Route::get('/submit', [UserController::class, 'submit'])->name('user.submit');
    
    //Author routes
    Route::get('/submit/step1', [AbstractSubmissionController::class, 'step1'])->name('user.step1');
    Route::post('/submit/step1', [AbstractSubmissionController::class, 'postStep1'])->name('submit.step1');

    Route::get('/submit/step2', [AbstractSubmissionController::class, 'step2'])->name('user.step2');
    Route::post('/submit/step2', [AbstractSubmissionController::class, 'postStep2'])->name('submit.step2');

    Route::get('/submit/preview', [AbstractSubmissionController::class, 'preview'])->name('user.preview');
    Route::post('/submit/preview', [AbstractSubmissionController::class, 'postPreview'])->name('submit.preview');
    Route::get('/submit/confirm', [UserController::class, 'confirm'])->name('submit.confirm');

    //
    Route::get('/submit/step1_research', [ResearchSubmissionController::class, 'step1_research'])->name('user.step1_research');
    Route::post('/submit/step1_research', [ResearchSubmissionController::class, 'postStep1_research'])->name('submit.step1_research');

    Route::get('/submit/step2_research', [ResearchSubmissionController::class, 'step2_research'])->name('user.step2_research');
    Route::post('/submit/step2_research', [ResearchSubmissionController::class, 'postStep2_research'])->name('submit.step2_research');
    
    Route::get('/submit/preview_research', [ResearchSubmissionController::class, 'preview_research'])->name('user.preview_research');
    Route::post('/submit/preview_research', [ResearchSubmissionController::class, 'postPreview_research'])->name('submit.preview_research');
    
    //
    //Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.partials.reviewed');
    
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Additional routes for authentication (if any)
require __DIR__.'/auth.php';

