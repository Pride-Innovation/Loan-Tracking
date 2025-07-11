<?php

namespace App\Http\Controllers;

use App\Models\ApprovalWorkFlows;
use App\Models\LoanProducts;
use App\Models\LoanStages;
use App\Http\Requests\StoreApprovalWorkFlowsRequest;
use App\Http\Requests\UpdateApprovalWorkFlowsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApprovalWorkFlowsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workflows = ApprovalWorkFlows::with(['loanProduct', 'stage'])
            ->orderBy('loan_product_id')
            ->orderBy('sequence')
            ->get();
        
        return Inertia::render('Settings/Workflows/Index', [
            'workflows' => $workflows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Workflows/Create', [
            'products' => LoanProducts::all(),
            'stages' => LoanStages::orderBy('order')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApprovalWorkFlowsRequest $request)
    {
        ApprovalWorkFlows::create($request->validated());
        
        return redirect()->route('approval-workflows.index')
            ->with('success', 'Approval workflow created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApprovalWorkFlows $approvalWorkFlow)
    {
        $approvalWorkFlow->load(['loanProduct', 'stage']);
        
        return Inertia::render('Settings/Workflows/Show', [
            'workflow' => $approvalWorkFlow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalWorkFlows $approvalWorkFlow)
    {
        return Inertia::render('Settings/Workflows/Edit', [
            'workflow' => $approvalWorkFlow,
            'products' => LoanProducts::all(),
            'stages' => LoanStages::orderBy('order')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApprovalWorkFlowsRequest $request, ApprovalWorkFlows $approvalWorkFlow)
    {
        $approvalWorkFlow->update($request->validated());
        
        return redirect()->route('approval-workflows.index')
            ->with('success', 'Approval workflow updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalWorkFlows $approvalWorkFlow)
    {
        $approvalWorkFlow->delete();
        
        return redirect()->route('approval-workflows.index')
            ->with('success', 'Approval workflow deleted successfully.');
    }

    /**
     * Get workflow for a specific loan.
     */
    public function getWorkflowForLoan($loanId)
    {
        $loan = \App\Models\LoanApplications::findOrFail($loanId);
        
        $workflow = ApprovalWorkFlows::getWorkflowForLoan($loan->loan_product_id, $loan->amount);
        
        return response()->json(['workflow' => $workflow]);
    }

    /**
     * Validate approval limits.
     */
    public function validateApprovalLimits(Request $request)
    {
        $request->validate([
            'loan_product_id' => 'required|exists:loan_products,id',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $isValid = true;
        $workflow = null;
        
        // Check if a workflow exists for this product and amount
        $workflow = ApprovalWorkFlows::where('loan_product_id', $request->loan_product_id)
            ->where('min_amount', '<=', $request->amount)
            ->where('max_amount', '>=', $request->amount)
            ->where('is_active', true)
            ->exists();
        
        if (!$workflow) {
            $isValid = false;
            
            // Find closest workflow
            $closestWorkflow = ApprovalWorkFlows::where('loan_product_id', $request->loan_product_id)
                ->orderByRaw('ABS(min_amount - ?)', [$request->amount])
                ->first();
        }
        
        return response()->json([
            'valid' => $isValid,
            'message' => $isValid 
                ? 'Amount is within approval limits.' 
                : 'No approval workflow found for this amount.',
            'closest_workflow' => $isValid ? null : $closestWorkflow
        ]);
    }
}
