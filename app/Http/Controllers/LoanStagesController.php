<?php

namespace App\Http\Controllers;

use App\Events\StageTransitioned;
use App\Models\LoanApplications;
use App\Models\LoanStages;
use App\Models\LoanStageHistory;
use App\Models\StageAssignments;
use App\Http\Requests\StoreLoanStagesRequest;
use App\Http\Requests\UpdateLoanStagesRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanStagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = LoanStages::orderBy('order')->get();
        
        return Inertia::render('Settings/Stages/Index', [
            'stages' => $stages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Stages/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanStagesRequest $request)
    {
        LoanStages::create($request->validated());
        
        return redirect()->route('loan-stages.index')
            ->with('success', 'Loan stage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanStages $loanStage)
    {
        return Inertia::render('Settings/Stages/Show', [
            'stage' => $loanStage
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanStages $loanStage)
    {
        return Inertia::render('Settings/Stages/Edit', [
            'stage' => $loanStage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanStagesRequest $request, LoanStages $loanStage)
    {
        $loanStage->update($request->validated());
        
        return redirect()->route('loan-stages.index')
            ->with('success', 'Loan stage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanStages $loanStage)
    {
        $loanStage->delete();
        
        return redirect()->route('loan-stages.index')
            ->with('success', 'Loan stage deleted successfully.');
    }

    /**
     * Assign an application to a stage.
     */
    public function assignToStage(Request $request)
    {
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'loan_stage_id' => 'required|exists:loan_stages,id',
            'user_id' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);
        
        $user = Auth::user();
        $loanApplication = LoanApplications::findOrFail($request->loan_application_id);
        $loanStage = LoanStages::findOrFail($request->loan_stage_id);
        
        // Create the assignment
        $assignment = StageAssignments::create([
            'loan_application_id' => $request->loan_application_id,
            'loan_stage_id' => $request->loan_stage_id,
            'user_id' => $request->user_id,
            'assigned_by' => $user->id,
            'status' => StageAssignments::STATUS_PENDING,
            'due_date' => $request->due_date ?? now()->addDays($loanStage->sla_days),
            'comments' => $request->comments,
        ]);
        
        // Fire stage assigned event
        event(new \App\Events\StageAssigned(
            $loanApplication,
            $loanStage,
            [$request->user_id]
        ));
        
        return redirect()->back()
            ->with('success', 'Stage assigned successfully.');
    }

    /**
     * Transition an application to a different stage.
     */
    public function transitionStage(Request $request)
    {
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'to_stage_id' => 'required|exists:loan_stages,id',
            'comments' => 'required|string',
        ]);
        
        $user = Auth::user();
        $loanApplication = LoanApplications::findOrFail($request->loan_application_id);
        $toStage = LoanStages::findOrFail($request->to_stage_id);
        $fromStage = $loanApplication->currentStage;
        
        // Check if user is assigned to the current stage
        $isAssigned = StageAssignments::where('loan_application_id', $loanApplication->id)
            ->where('loan_stage_id', $loanApplication->current_stage_id)
            ->where('user_id', $user->id)
            ->where('status', '!=', StageAssignments::STATUS_COMPLETED)
            ->exists();
            
        if (!$isAssigned && !$user->hasRole(['admin', 'manager'])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to transition this application.');
        }
        
        // Update current stage assignment to completed
        StageAssignments::where('loan_application_id', $loanApplication->id)
            ->where('loan_stage_id', $loanApplication->current_stage_id)
            ->where('status', '!=', StageAssignments::STATUS_COMPLETED)
            ->update([
                'status' => StageAssignments::STATUS_COMPLETED,
                'completed_at' => now(),
                'comments' => $request->comments
            ]);
        
        // Calculate time spent in previous stage
        $timeSpent = 0;
        if ($fromStage) {
            $stageAssignment = StageAssignments::where('loan_application_id', $loanApplication->id)
                ->where('loan_stage_id', $fromStage->id)
                ->latest()
                ->first();
            
            if ($stageAssignment) {
                $startTime = $stageAssignment->created_at;
                $endTime = now();
                $timeSpent = $startTime->diffInMinutes($endTime);
            }
        }
        
        // Log the stage history
        LoanStageHistory::create([
            'loan_application_id' => $loanApplication->id,
            'loan_stage_id' => $fromStage ? $fromStage->id : null,
            'user_id' => $user->id,
            'action' => LoanStageHistory::ACTION_COMPLETED,
            'comments' => $request->comments,
            'time_spent' => $timeSpent,
        ]);
        
        // Update the application's current stage
        $loanApplication->update(['current_stage_id' => $toStage->id]);
        
        // Create new stage history for entering the new stage
        LoanStageHistory::create([
            'loan_application_id' => $loanApplication->id,
            'loan_stage_id' => $toStage->id,
            'user_id' => $user->id,
            'action' => LoanStageHistory::ACTION_STARTED,
            'comments' => "Moved to {$toStage->name} stage",
        ]);
        
        // Fire the stage transitioned event
        event(new StageTransitioned(
            $loanApplication,
            $fromStage,
            $toStage,
            $user,
            $request->comments
        ));
        
        return redirect()->back()
            ->with('success', 'Application transitioned to new stage successfully.');
    }

    /**
     * Add a comment to a stage.
     */
    public function addComment(Request $request)
    {
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'comments' => 'required|string',
        ]);
        
        $user = Auth::user();
        $loanApplication = LoanApplications::findOrFail($request->loan_application_id);
        
        // Add comment to stage history
        LoanStageHistory::create([
            'loan_application_id' => $loanApplication->id,
            'loan_stage_id' => $loanApplication->current_stage_id,
            'user_id' => $user->id,
            'action' => 'comment',
            'comments' => $request->comments,
        ]);
        
        return redirect()->back()
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Get the stage history for a loan.
     */
    public function getStageHistory($loanId)
    {
        $history = LoanStageHistory::where('loan_application_id', $loanId)
            ->with(['user', 'loanStage'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json(['history' => $history]);
    }

    /**
     * Calculate turnaround time for a loan.
     */
    public function calculateTAT($loanId)
    {
        $loanApplication = LoanApplications::findOrFail($loanId);
        $history = LoanStageHistory::where('loan_application_id', $loanId)
            ->with('loanStage')
            ->orderBy('created_at')
            ->get();
        
        $stages = [];
        $totalTimeInMinutes = 0;
        
        foreach ($history as $index => $record) {
            if (!isset($stages[$record->loan_stage_id])) {
                $stages[$record->loan_stage_id] = [
                    'stage' => $record->loanStage->name,
                    'started_at' => $record->created_at,
                    'completed_at' => null,
                    'time_spent' => 0,
                ];
            }
            
            if ($record->action === LoanStageHistory::ACTION_COMPLETED) {
                $stages[$record->loan_stage_id]['completed_at'] = $record->created_at;
                $stages[$record->loan_stage_id]['time_spent'] = $record->time_spent;
                $totalTimeInMinutes += $record->time_spent;
            }
        }
        
        $totalDays = round($totalTimeInMinutes / (60 * 24), 1);
        $totalHours = round($totalTimeInMinutes / 60, 1);
        
        return response()->json([
            'stages' => array_values($stages),
            'total_time_minutes' => $totalTimeInMinutes,
            'total_time_hours' => $totalHours,
            'total_time_days' => $totalDays,
        ]);
    }
}
