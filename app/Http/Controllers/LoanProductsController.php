<?php

namespace App\Http\Controllers;

use App\Models\LoanProducts;
use App\Http\Requests\StoreLoanProductsRequest;
use App\Http\Requests\UpdateLoanProductsRequest;

class LoanProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanProductsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanProducts $loanProducts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanProducts $loanProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanProductsRequest $request, LoanProducts $loanProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanProducts $loanProducts)
    {
        //
    }
}
