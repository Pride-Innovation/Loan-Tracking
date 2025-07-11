<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanApplicationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_reference' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'branch_id' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'loan_product_id' => 'required|exists:loan_products,id',
            'description' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
