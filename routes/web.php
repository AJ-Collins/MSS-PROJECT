<?php

use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbstractSubmissionController;
use App\Http\Controllers\ResearchSubmissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AbstractsController;
use App\Http\Controllers\ProposalController;

Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
    ->name('verification.resend');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::view('/', 'welcome');

//Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

    Route::post('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users/{reg_no}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/{reg_no}/updateRole', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/assign-abstract-reviewer/{serial_number}', [AdminController::class, 'assignAbstractReviewer'])->name('assign.abstract.reviewer');
    Route::post('/remove-abstract-reviewer/{serial_number}', [AdminController::class, 'removeAbstractReviewer'])->name('remove.abstract.reviewer');
    Route::post('/assign-proposal-reviewer/{serial_number}', [AdminController::class, 'assignProposalReviewer'])->name('assign.proposal.reviewer');
    Route::post('/remove-proposal-reviewer/{serial_number}', [AdminController::class, 'removeProposalReviewer'])->name('remove.proposal.reviewer');
    Route::post('/abstracts/assign-mass-reviewer', [AdminController::class, 'assignAbstractMassReviewer'])->name('assign.mass.reviewer');
    Route::post('/proposals/assign-mass-reviewer', [AdminController::class, 'assignProposalMassReviewer'])
        ->name('assign.proposal.massReviewer');
  

    Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/documents', [AdminController::class, 'documents'])->name('admin.documents');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.partials.profile');
    Route::post('/approve-abstract', [AdminController::class, 'approveAbstract'])->name('approve.abstract');
    Route::post('/reject-abstract', [AdminController::class, 'rejectAbstract'])->name('reject.abstract');
    Route::post('/approve-proposal', [AdminController::class, 'approveProposal'])->name('approve.proposal');
    Route::post('/reject-proposal', [AdminController::class, 'rejectProposal'])->name('reject.proposal');
});

//Reviewer routes
Route::prefix('reviewer')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('reviewer.partials.dashboard');
    Route::get('/assigned-abstracts', [ReviewerController::class, 'assignedAbstracts'])->name('reviewer.assignedAbstracts');
    Route::get('/documents', [ReviewerController::class, 'documentsReview'])->name('reviewer.partials.documents');
    Route::get('/assessment/abstract/{serial_number}', [ReviewerController::class, 'AbstractAssessment'])->name('reviewer.abstract.assessment');
    Route::post('/assessment/abstract/{serial_number}', [ReviewerController::class, 'AbstractAssessmentStore'])->name('reviewer.abstracts.assessment.store');
    Route::get('/assessment/abstracts/{serial_number}', [ReviewerController::class, 'AbstracPreview'])->name('reviewer.assessment.abstractpreview');
    Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.partials.reviewed');
    Route::get('/profile', [ReviewerController::class, 'profile'])->name('reviewer.partials.profile');
    

    Route::get('/abstracts/{serial_number}', [ReviewerController::class, 'getAbstract']);
    Route::get('/proposals/{serial_number}', [ReviewerController::class, 'getProposal']);

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
    
    Route::get('/user/documents/proposal/{serial_number}', [UserController::class, 'viewProposal'])
                ->name('documents.proposal.view');
    
    //Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.partials.reviewed');
    
});

//Abstarct download routes
Route::get('/abstracts/{serial_number}/pdf', [AbstractsController::class, 'downloadPdf'])->name('research.abstract.download');
Route::get('/abstracts/{serial_number}/word', [AbstractsController::class, 'downloadWord'])->name('abstract.abstractWord.download');

//Download all Abstarct routes
Route::get('/abstracts/download-all', [AbstractsController::class, 'downloadAllAbstracts'])->name('abstract.downloadAll');
Route::get('/abstracts/download-word', [AbstractsController::class, 'downloadAllAbstractsWord'])->name('abstracts.download.word');

//Proposal download routes
Route::get('/proposals/{serial_number}/pdf', [ProposalController::class, 'downloadPdf'])->name('proposal.abstract.download');
Route::get('/proposals/{serial_number}/word', [ProposalController::class, 'downloadProposalWord'])->name('proposal.abstractWord.download');
//Download all Proposal Abstarct routes
Route::get('/proposals/download-all', [ProposalController::class, 'downloadAllProposalAbstracts'])->name('proposal.downloadAll');
Route::get('/proposals/download-word', [ProposalController::class, 'downloadAllProposalAbstractsWord'])->name('proposal.downloadAllWord');
