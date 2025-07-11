<?php

namespace App\Http\Controllers;

use App\Events\StageAssigned;
use App\Events\StageCompleted;
use App\Models\LoanApplications;
use App\Models\LoanStages;
use App\Models\StageAssignments;
use App\Models\User;
use App\Http\Requests\StoreStageAssignmentsRequest;
use App\Http\Requests\UpdateStageAssignmentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StageAssignments::with(['loanApplication', 'loanStage', 'user']);
        
        // Apply filters
        if ($request->has('loan_id')) {
            $query->where('loan_application_id', $request->loan_id);
        }
        
        if ($request->has('stage_id')) {
            $query->where('loan_stage_id', $request->stage_id);
        }
        
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $assignments = $query->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json([
            'assignments' => $assignments
        ]);
    }

    /**
     * Assign users to a stage.
     */
    public function assign(Request $request)
    {
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'loan_stage_id' => 'required|exists:loan_stages,id',
            'user_id' => 'required|exists:users,id',
            'comments' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        $loanApplication = LoanApplications::findOrFail($request->loan_application_id);
        $loanStage = LoanStages::findOrFail($request->loan_stage_id);
        
        $assignment = StageAssignments::create([
            'loan_application_id' => $request->loan_application_id,
            'loan_stage_id' => $request->loan_stage_id,
            'user_id' => $request->user_id,
            'assigned_by' => $user->id,
            'status' => StageAssignments::STATUS_PENDING,
            'due_date' => now()->addDays($loanStage->sla_days),
            'comments' => $request->comments,
        ]);
        
        // Fire stage assigned event
        event(new StageAssigned(
            $loanApplication,
            $loanStage,
            [$request->user_id]
        ));
        
        return response()->json([
            'success' => true,
            'assignment' => $assignment
        ]);
    }

    /**
     * Assign multiple users to a stage.
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'loan_stage_id' => 'required|exists:loan_stages,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'comments' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        $loanApplication = LoanApplications::findOrFail($request->loan_application_id);
        $loanStage = LoanStages::findOrFail($request->loan_stage_id);
        
        $assignments = [];
        
        foreach ($request->user_ids as $userId) {
            $assignment = StageAssignments::create([
                'loan_application_id' => $request->loan_application_id,
                'loan_stage_id' => $request->loan_stage_id,
                'user_id' => $userId,
                'assigned_by' => $user->id,
                'status' => StageAssignments::STATUS_PENDING,
                'due_date' => now()->addDays($loanStage->sla_days),
                'comments' => $request->comments,
            ]);
            
            $assignments[] = $assignment;
        }
        
        // Fire stage assigned event
        event(new StageAssigned(
            $loanApplication,
            $loanStage,
            $request->user_ids
        ));
        
        return response()->json([
            'success' => true,
            'assignments' => $assignments
        ]);
    }

    /**
     * Reassign a stage to a different user.
     */
    public function reassign(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:stage_assignments,id',
            'new_user_id' => 'required|exists:users,id',
            'comments' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        $assignment = StageAssignments::findOrFail($request->assignment_id);
        
        // Close the current assignment
        $assignment->update([
            'status' => StageAssignments::STATUS_COMPLETED,
            'completed_at' => now(),
            'comments' => $request->comments ?? 'Reassigned to another user',
        ]);
        
        // Create a new assignment for the new user
        $newAssignment = StageAssignments::create([
            'loan_application_id' => $assignment->loan_application_id,
            'loan_stage_id' => $assignment->loan_stage_id,
            'user_id' => $request->new_user_id,
            'assigned_by' => $user->id,
            'status' => StageAssignments::STATUS_PENDING,
            'due_date' => $assignment->due_date,
            'comments' => $request->comments ?? 'Reassigned from another user',
        ]);
        
        // Fire stage assigned event
        $loanApplication = LoanApplications::find($assignment->loan_application_id);
        $loanStage = LoanStages::find($assignment->loan_stage_id);
        
        event(new StageAssigned(
            $loanApplication,
            $loanStage,
            [$request->new_user_id]
        ));
        
        return response()->json([
            'success' => true,
            'assignment' => $newAssignment
        ]);
    }

    /**
     * Mark an assignment as complete.
     */
    public function complete(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:stage_assignments,id',
            'action' => 'required|in:approve,reject,return',
            'comments' => 'required|string',
        ]);
        
        $user = Auth::user();
        $assignment = StageAssignments::with(['loanApplication', 'loanStage'])
            ->findOrFail($request->assignment_id);
        
        // Check if the user is authorized to complete this assignment
        if ($assignment->user_id != $user->id && !$user->hasRole(['admin', 'manager'])) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to complete this assignment'
            ], 403);
        }
        
        // Update the assignment
        $assignment->update([
            'status' => StageAssignments::STATUS_COMPLETED,
            'completed_at' => now(),
            'comments' => $request->comments,
        ]);
        
        // Fire stage completed event
        event(new StageCompleted(
            $assignment->loanApplication,
            $assignment->loanStage,
            $user,
            $request->action
        ));
        
        return response()->json([
            'success' => true,
            'assignment' => $assignment
        ]);
    }

    /**
     * Get assignments for the current user.
     */
    public function getMyAssignments(Request $request)
    {
        $user = Auth::user();
        $status = $request->status ?? 'pending';
        
        $query = StageAssignments::with(['loanApplication', 'loanStage'])
            ->where('user_id', $user->id);
            
        if ($status === 'pending') {
            $query->whereIn('status', [
                StageAssignments::STATUS_PENDING,
                StageAssignments::STATUS_IN_PROGRESS,
                StageAssignments::STATUS_OVERDUE
            ]);
        } else if ($status === 'completed') {
            $query->where('status', StageAssignments::STATUS_COMPLETED);
        }
        
        $assignments = $query->orderBy('due_date')
            ->paginate(10);
            
        return response()->json([
            'assignments' => $assignments
        ]);
    }
}
