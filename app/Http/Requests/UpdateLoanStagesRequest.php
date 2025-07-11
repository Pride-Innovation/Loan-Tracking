<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanStagesRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'sometimes|required|integer|min:1',
            'sla_days' => 'sometimes|required|integer|min:0',
            'is_final' => 'boolean',
            'required_role' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ];
    }
}
