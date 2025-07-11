<?php

namespace App\Http\Controllers;

use App\Events\LoanApplicationCreated;
use App\Events\LoanApplicationDeleted;
use App\Events\LoanApplicationUpdated;
use App\Models\Branches;
use App\Models\LoanApplications;
use App\Models\LoanProducts;
use App\Models\LoanStages;
use App\Models\Regions;
use App\Models\StageAssignments;
use App\Http\Requests\StoreLoanApplicationsRequest;
use App\Http\Requests\UpdateLoanApplicationsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class LoanApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = LoanApplications::query();
        
        // Apply filters if present
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        
        if ($request->has('region_id')) {
            $query->where('region_id', $request->region_id);
        }
        
        if ($request->has('product_id')) {
            $query->where('loan_product_id', $request->product_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Role-based filtering
        if (!$user->hasRole(['admin', 'manager'])) {
            // Only show applications that the user is related to
            $query->where(function ($query) use ($user) {
                $query->where('relationship_officer_id', $user->id)
                    ->orWhereHas('stageAssignments', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            });
        }
        
        $applications = $query->with(['branch', 'region', 'relationshipOfficer', 'loanProduct', 'currentStage'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return Inertia::render('LoanLeads/Index', [
            'applications' => $applications,
            'filters' => $request->all(),
            'branches' => Branches::all(),
            'regions' => Regions::all(),
            'products' => LoanProducts::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        return Inertia::render('LoanLeads/Create', [
            'branches' => Branches::all(),
            'regions' => Regions::all(),
            'products' => LoanProducts::all(),
            'userBranch' => $user->branch_id,
            'userRegion' => $user->region_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanApplicationsRequest $request)
    {
        $user = Auth::user();
        
        // Generate a unique application number
        $applicationNumber = $this->generateApplicationNumber();
        
        $validatedData = $request->validated();
        $application = LoanApplications::create([
            'application_number' => $applicationNumber,
            'customer_name' => $validatedData['customer_name'],
            'customer_reference' => $validatedData['customer_reference'],
            'amount' => $validatedData['amount'],
            'branch_id' => $validatedData['branch_id'] ?? $user->branch_id,
            'region_id' => $validatedData['region_id'] ?? $user->region_id,
            'relationship_officer_id' => $user->id,
            'loan_product_id' => $validatedData['loan_product_id'],
            'application_date' => now(),
            'status' => 'pending',
            'description' => $validatedData['description'] ?? null,
            'remarks' => $validatedData['remarks'] ?? null,
        ]);
        
        // Get the initial stage for this loan product
        $initialStage = LoanStages::where('order', 1)->where('is_active', true)->first();
        
        if ($initialStage) {
            $application->update(['current_stage_id' => $initialStage->id]);
            
            // Create stage assignment for the first stage
            StageAssignments::create([
                'loan_application_id' => $application->id,
                'loan_stage_id' => $initialStage->id,
                'user_id' => $user->id,
                'assigned_by' => $user->id,
                'status' => StageAssignments::STATUS_IN_PROGRESS,
                'due_date' => now()->addDays($initialStage->sla_days),
            ]);
        }
        
        // Fire the created event
        event(new LoanApplicationCreated($application, $user));
        
        return redirect()->route('leads')->with('success', 'Loan application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $application = LoanApplications::with([
            'branch', 
            'region', 
            'relationshipOfficer', 
            'loanProduct', 
            'currentStage',
            'stageAssignments.user',
            'stageAssignments.loanStage',
            'stageHistory.user',
            'stageHistory.loanStage',
        ])->findOrFail($id);
        
        return Inertia::render('LoanLeads/Show', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $application = LoanApplications::findOrFail($id);
        
        return Inertia::render('LoanLeads/Edit', [
            'application' => $application,
            'branches' => Branches::all(),
            'regions' => Regions::all(),
            'products' => LoanProducts::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanApplicationsRequest $request, $id)
    {
        $user = Auth::user();
        $application = LoanApplications::findOrFail($id);
        
        $changes = [];
        $oldValues = $application->getAttributes();
        
        $application->update($request->validated());
        
        // Track changes
        $newValues = $application->getAttributes();
        foreach ($oldValues as $key => $value) {
            if (isset($newValues[$key]) && $newValues[$key] !== $value) {
                $changes[$key] = [
                    'old' => $value,
                    'new' => $newValues[$key]
                ];
            }
        }
        
        // Fire the updated event if there were changes
        if (!empty($changes)) {
            event(new LoanApplicationUpdated($application, $user, $changes));
        }
        
        return redirect()->route('leads.show', $application->id)
            ->with('success', 'Loan application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $application = LoanApplications::findOrFail($id);
        
        // Store ID before deletion
        $applicationId = $application->id;
        
        // Delete the application
        $application->delete();
        
        // Fire the deleted event
        event(new LoanApplicationDeleted($applicationId, $user));
        
        return redirect()->route('leads')
            ->with('success', 'Loan application deleted successfully.');
    }

    /**
     * Show applications that belong to the current RO.
     */
    public function myApplications()
    {
        $user = Auth::user();
        
        $applications = LoanApplications::where('relationship_officer_id', $user->id)
            ->with(['branch', 'region', 'loanProduct', 'currentStage'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return Inertia::render('LoanLeads/MyApplications', [
            'applications' => $applications,
        ]);
    }

    /**
     * Show applications pending the current user's review.
     */
    public function pendingReview()
    {
        $user = Auth::user();
        
        $applications = LoanApplications::whereHas('stageAssignments', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereIn('status', [
                    StageAssignments::STATUS_PENDING,
                    StageAssignments::STATUS_IN_PROGRESS,
                    StageAssignments::STATUS_OVERDUE
                ]);
        })
        ->with(['branch', 'region', 'loanProduct', 'currentStage', 'stageAssignments.loanStage'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return Inertia::render('LoanLeads/PendingReview', [
            'applications' => $applications,
        ]);
    }

    /**
     * Generate a unique application number.
     */
    private function generateApplicationNumber()
    {
        $prefix = 'LN-' . date('Ym') . '-';
        $random = Str::random(4);
        $number = $prefix . $random;
        
        // Check if number exists and regenerate if needed
        while (LoanApplications::where('application_number', $number)->exists()) {
            $random = Str::random(4);
            $number = $prefix . $random;
        }
        
        return $number;
    }
}
