<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoanApplicationsController;
use App\Http\Controllers\LoanStagesController;
use App\Http\Controllers\ApprovalWorkFlowsController;
use App\Http\Controllers\StageAssignmentsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    // Loan Applications Routes
    Route::get('/leads', [LoanApplicationsController::class, 'index'])->name('leads');
    Route::get('/leads/create', [LoanApplicationsController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LoanApplicationsController::class, 'store'])->name('leads.store');
    Route::get('/leads/{id}', [LoanApplicationsController::class, 'show'])->name('leads.show');
    Route::get('/leads/{id}/edit', [LoanApplicationsController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{id}', [LoanApplicationsController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{id}', [LoanApplicationsController::class, 'destroy'])->name('leads.destroy');
    Route::get('/my-applications', [LoanApplicationsController::class, 'myApplications'])->name('my-applications');
    Route::get('/pending-review', [LoanApplicationsController::class, 'pendingReview'])->name('pending-review');
    
    // Loan Stages Routes
    Route::resource('loan-stages', LoanStagesController::class);
    Route::post('/stages/assign', [LoanStagesController::class, 'assignToStage'])->name('stages.assign');
    Route::post('/stages/transition', [LoanStagesController::class, 'transitionStage'])->name('stages.transition');
    Route::post('/stages/comment', [LoanStagesController::class, 'addComment'])->name('stages.comment');
    Route::get('/stages/history/{loanId}', [LoanStagesController::class, 'getStageHistory'])->name('stages.history');
    Route::get('/stages/tat/{loanId}', [LoanStagesController::class, 'calculateTAT'])->name('stages.tat');
    
    // Approval Workflows Routes
    Route::resource('approval-workflows', ApprovalWorkFlowsController::class);
    Route::get('/workflows/loan/{loanId}', [ApprovalWorkFlowsController::class, 'getWorkflowForLoan'])->name('workflows.for-loan');
    Route::post('/workflows/validate-limits', [ApprovalWorkFlowsController::class, 'validateApprovalLimits'])->name('workflows.validate-limits');
    
    // Stage Assignments Routes
    Route::get('/assignments', [StageAssignmentsController::class, 'index'])->name('assignments.index');
    Route::post('/assignments/assign', [StageAssignmentsController::class, 'assign'])->name('assignments.assign');
    Route::post('/assignments/bulk-assign', [StageAssignmentsController::class, 'bulkAssign'])->name('assignments.bulk-assign');
    Route::post('/assignments/reassign', [StageAssignmentsController::class, 'reassign'])->name('assignments.reassign');
    Route::post('/assignments/complete', [StageAssignmentsController::class, 'complete'])->name('assignments.complete');
    Route::get('/my-assignments', [StageAssignmentsController::class, 'getMyAssignments'])->name('my-assignments');
    
    Route::get('/products', function () {
        return Inertia::render('Products/Index');
    })->name('products');

    Route::get('/settings', function () {
        return Inertia::render('Settings/Index');
    })->name('settings');

    Route::get('/reports', function () {
        return Inertia::render('Reporting/Index');
    })->name('reports');
});
