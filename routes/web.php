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
use App\Http\Controllers\RoleSwitcher;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

Auth::routes();
Route::post('/api/csp-report', 'SecurityController@handleCspReport');
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
    ->name('verification.resend');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Home Route
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['preventBackHistory', 'auth'])->group(function () {
    
    //Role switching
    Route::post('/switch-role', [RoleSwitcher::class, 'switchRole'])
        ->name('switch.role');
    
     //Notifications
     Route::get('/notifications', [NotificationController::class, 'getNotifications']);
     Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
     Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    //Admin routes
    Route::middleware('can:view-admin-dashboard')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/documents-search', [AdminController::class, 'documentsSearch'])->name('admin.documents-search');
        Route::delete('/delete/documents/{serial_number}', [AdminController::class, 'deleteDocuments'])->name('admin.documentsDelete');
        Route::delete('/delete/assessment/{serial_number}', [AdminController::class, 'deleteAssessment'])->name('admin.assessmentDelete');

        Route::post('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::delete('/delete/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
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
        Route::get('/abstracts', [AdminController::class, 'abstracts'])->name('admin.abstracts');


        Route::get('/proposals', [AdminController::class, 'proposals'])->name('admin.proposals');
        Route::get('/api/research-submissions', [AdminController::class, 'fetchResearchSubmissions']);
        Route::get('/api/abstract-submissions', [AdminController::class, 'fetchAbstractSubmissions']);
        Route::get('/api/reviewers', [AdminController::class, 'getReviewers']);

        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/accept-abstract', [AdminController::class, 'acceptAbstract'])->name('accept.abstract');
        Route::post('/reject-abstract', [AdminController::class, 'rejectAbstract'])->name('reject.abstract');
        Route::post('/accept-proposal', [AdminController::class, 'acceptProposal'])->name('accept.proposal');
        Route::post('/reject-proposal', [AdminController::class, 'rejectProposal'])->name('reject.proposal');
        Route::get('/request-article-upload/{serial_number}', [AdminController::class, 'requestArticleUpload'])->name('request.article.upload');
        Route::post('/approve-abstract', [AdminController::class, 'approveAbstract'])->name('approve.abstract');
        Route::post('/unapprove-abstract', [AdminController::class, 'unapproveAbstract'])->name('unapprove.abstract');
        Route::post('/approve-proposal', [AdminController::class, 'approveProposal'])->name('approve.proposal');
        Route::post('/unapprove-proposal', [AdminController::class, 'unapproveProposal'])->name('unapprove.proposal');

        Route::get('/research-assessments/{serial_number}', [AdminController::class, 'showAssessments'])->name('admin.showAssessments');
        Route::get('/proposal-assessments/{serial_number}', [AdminController::class, 'showProposalAssessments'])->name('admin.proposal.showAssessments');

        Route::post('/accept-abstract-revision', [AdminController::class, 'acceptRevision'])->name('accept.abstract.revision');
        Route::post('/reject-abstract-revision', [AdminController::class, 'rejectRevision'])->name('reject.abstract.revision');
        Route::post('/reject/assessment/{serial_number}', [AdminController::class, 'rejectAssessment'])->name('reject.assessment');
        Route::post('/reviewer-abstract-revision/{serial_number}', [AdminController::class, 'returnRevision'])->name('return.reviewer.abstract.revision');

        Route::post('/accept-proposal-revision', [AdminController::class, 'acceptProposalRevision'])->name('accept.proposal.revision');
        Route::post('/reject-proposal-revision', [AdminController::class, 'rejectProposalRevision'])->name('reject.proposal.revision');
        Route::post('/reject/proposal-assessment/{serial_number}', [AdminController::class, 'rejectProposalAssessment'])->name('reject.proposal.assessment');
        Route::post('/reviewer-proposal-revision/{serial_number}', [AdminController::class, 'returnProposalRevision'])->name('return.reviewer.proposal.revision');

        Route::get('/abstract/details/{serial_number}', [AdminController::class, 'abstractDetails'])->name('admin.abstract.details');
        Route::get('/proposal/details/{serial_number}', [AdminController::class, 'proposalDetails'])->name('admin.proposal.details');

        Route::get('/submission-types', [AdminController::class, 'index'])->name('submission-types.index');
        Route::post('/submission-types/store', [AdminController::class, 'store'])->name('admin.submission-types.store');
        Route::delete('/submission-types/{submissionType}', [AdminController::class, 'destroy'])->name('admin.submission-types.destroy');
        Route::get('/submission-types/{id}/edit', [AdminController::class, 'edit'])->name('admin.submission-types.edit');
        Route::put('/submission-types/{submissionType}', [AdminController::class, 'update'])
            ->name('admin.submission-types.update');
    });

    //Reviewer routes
    Route::middleware('can:view-reviewer-dashboard')->prefix('reviewer')->group(function () {
        Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('reviewer.dashboard');
        Route::get('/assigned-abstracts', [ReviewerController::class, 'assignedAbstracts'])->name('reviewer.assignedAbstracts');
        Route::get('/documents', [ReviewerController::class, 'documentsReview'])->name('reviewer.documents');
        Route::get('/assessment/abstract/{serial_number}', [ReviewerController::class, 'AbstractAssessment'])->name('reviewer.abstract.assessment');
        Route::get('/assessment/proposal-view/{serial_number}', [ReviewerController::class, 'ProposalAssessment'])->name('reviewer.proposal.assessment');
        Route::post('/assessment/abstract/{serial_number}', [ReviewerController::class, 'AbstractAssessmentStore'])->name('reviewer.abstracts.assessment.store');
        Route::post('/assessment/proposal-store/{serial_number}', [ReviewerController::class, 'ProposalAssessmentStore'])->name('reviewer.proposal.assessment.store');
        Route::get('/assessment/abstracts/{serial_number}', [ReviewerController::class, 'AbstracPreview'])->name('reviewer.assessment.abstractpreview');
        Route::get('/assessment/proposal/{serial_number}', [ReviewerController::class, 'ProposalPreview'])->name('reviewer.assessment.proposalpreview');
        Route::get('/reviewed', [ReviewerController::class, 'revieweddocuments'])->name('reviewer.reviewed');
        Route::get('/profile', [ReviewerController::class, 'profile'])->name('reviewer.profile');
        Route::get('/abstract/accept/{serial_number}', [ReviewerController::class, 'acceptAssignment'])->name('reviewer.abstract.accept');
        Route::get('/abstract/reject/{serial_number}', [ReviewerController::class, 'declineAssignment'])->name('reviewer.abstract.reject');
        Route::get('/proposal/accept/{serial_number}', [ReviewerController::class, 'acceptProposal'])->name('reviewer.proposal.accept');
        Route::get('/proposal/reject/{serial_number}', [ReviewerController::class, 'rejectProposal'])->name('reviewer.proposal.reject');
        

        Route::get('/abstracts/{serial_number}', [ReviewerController::class, 'getAbstract']);
        Route::get('/proposals/{serial_number}', [ReviewerController::class, 'getProposal']);

        Route::post('/abstract/revision/{serial_number}', [ReviewerController::class, 'requestAbstractRevision'])->name('reviewer.abstract.revision');

    });
    //User routes
    Route::middleware('can:view-user-dashboard')->prefix('user')->group(function () {
        Route::get('/user-profile', [UserController::class, 'profile'])->name('user.profile');
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
        
        Route::get('/submit-article/{serial_number}', [UserController::class, 'submitArticle'])->name('user.submit.article');
        Route::post('/upload-article', [AbstractSubmissionController::class, 'PostSubmitArticle'])->name('user.upload.article');

        //
        Route::get('/submit/step1_research', [ResearchSubmissionController::class, 'step1_research'])->name('user.step1_research');
        Route::post('/submit/step1_research', [ResearchSubmissionController::class, 'postStep1_research'])->name('submit.step1_research');

        Route::get('/submit/step2_research', [ResearchSubmissionController::class, 'step2_research'])->name('user.step2_research');
        Route::post('/submit/step2_research', [ResearchSubmissionController::class, 'postStep2_research'])->name('submit.step2_research');
        Route::post('/delete-file-session', function () {
            if (session()->has('abstract.pdf_document_path')) {
                Storage::disk('public')->delete(session('abstract.pdf_document_path'));
                // Forget the file path from the session
                session()->forget('abstract.pdf_document_path');
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'No file found']);
        });
        Route::get('/download-abstract-pdf', [ResearchSubmissionController::class, 'downloadAbstractPdf'])->name('user.downloadAbstractPdf');
        
        Route::get('/submit/preview_research', [ResearchSubmissionController::class, 'preview_research'])->name('user.preview_research');
        Route::post('/submit/preview_research', [ResearchSubmissionController::class, 'postPreview_research'])->name('submit.preview_research');
        
        Route::get('/user/documents/proposal/{serial_number}', [UserController::class, 'viewProposal'])
                    ->name('documents.proposal.view');
        //Drafts routes
        Route::post('/drafts/save', [AbstractSubmissionController::class, 'saveDraft'])->name('user.saveDraft');   
        Route::get('/resume-draft/{serialNumber}', [AbstractSubmissionController::class, 'resumeDraft'])->where('serialNumber', '.+')->name('user.resume-draft');
        Route::get('/drafts', [AbstractSubmissionController::class, 'viewDrafts'])->name('user.drafts');
        Route::delete('/drafts/delete/{serialNumber}', [AbstractSubmissionController::class, 'deleteDraft'])->where('serialNumber', '.+')->name('user.delete-draft');

        //Proposal Draft routes
        Route::post('/proposal-drafts/save', [ResearchSubmissionController::class, 'saveProposalDraft'])->name('user.save.proposal.draft');    
        Route::get('/resume-proposal-draft/{serialNumber}', [ResearchSubmissionController::class, 'resumeProposalDraft'])->where('serialNumber', '.+')->name('user.resume.proposal.draft');
        Route::get('/proposal-view-drafts', [ResearchSubmissionController::class, 'viewProposalDrafts'])->name('user.proposal.drafts');
        Route::delete('/proposal-drafts/delete/{serialNumber}', [ResearchSubmissionController::class, 'deleteProposalDraft'])->where('serialNumber', '.+')->name('user.delete.proposal.draft');

       
    });

    //Abstarct download routes
    Route::get('/abstracts/{serial_number}/pdf', [AbstractsController::class, 'downloadPdf'])->name('research.abstract.download');
    Route::get('/abstracts/reviewer/{serial_number}/pdf', [AbstractsController::class, 'reviwerDownloadPdf'])->name('research.reviewerAbstract.download');
    Route::get('/abstracts/{serial_number}/word', [AbstractsController::class, 'downloadWord'])->name('abstract.abstractWord.download');
    Route::get('/abstracts/reviewer/{serial_number}/word', [AbstractsController::class, 'reviwerDownloadWord'])->name('abstract.reviwerAbstractWord.download');

    //Download all Abstarct routes
    Route::get('/abstracts/download-all', [AbstractsController::class, 'downloadAllAbstracts'])->name('abstract.downloadAll');
    Route::get('/abstracts/download-word', [AbstractsController::class, 'downloadAllAbstractsWord'])->name('abstracts.download.word');

    //Proposal download routes
    Route::get('/proposals/{serial_number}/pdf', [ProposalController::class, 'downloadPdf'])->name('proposal.abstract.download');
    Route::get('/proposals/reviewer/{serial_number}/pdf', [ProposalController::class, 'reviewerDownloadPdf'])->name('proposal.reviewerAbstract.download');
    Route::get('/proposals/{serial_number}/word', [ProposalController::class, 'downloadProposalWord'])->name('proposal.abstractWord.download');
    Route::get('/proposals/reviewer/{serial_number}/word', [ProposalController::class, 'downloadReviewerProposalWord'])->name('proposal.reviewerAbstractWord.download');
    //Download all Proposal Abstarct routes
    Route::get('/proposals/download-all', [ProposalController::class, 'downloadAllProposalAbstracts'])->name('proposal.downloadAll');
    Route::get('/proposals/download-word', [ProposalController::class, 'downloadAllProposalAbstractsWord'])->name('proposal.downloadAllWord');


    Route::get('/download/{serialNumber}', [ResearchSubmissionController::class, 'downloadFile'])->name('download.file');


    Route::get('/research_assessments/{abstract_submission_id}/download-pdf', [AbstractsController::class, 'downloadAssessmentPDF'])->name('assessments.download-pdf');
    Route::get('/proposal/research_assessments/{abstract_submission_id}/download-pdf', [ProposalController::class, 'downloadProposalAssessmentPDF'])->name('assessments.proposal.download-pdf');
    Route::post('/upload-profile-photo', [ProfileController::class, 'uploadPhoto'])->name('upload.profile.photo');

    Route::get('/abstracts/assessment/{serial_number}/pdf', [AbstractsController::class, 'downloadPdfAssessment'])->name('abstract.asessment.download');
    Route::get('/abstracts/assessment/proposal/{serial_number}/pdf', [AbstractsController::class, 'downloadPdfAssessmentProposal'])->name('abstract.proposalAssessment.download');

    Route::get('/download-assessment/{serial_number}/{reviewer_reg_no}', [AbstractsController::class, 'downloadPdfAssessmentForAnyone'])->name('assessment.download.anyone');
    Route::get('/download-proposalAssessment/{serial_number}/{reviewer_reg_no}', [AbstractsController::class, 'downloadPdfProposalAssessmentForAnyone'])->name('proposalAssessment.download.anyone');

});