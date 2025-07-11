<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalWorkFlows extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalWorkFlowsFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_product_id',
        'stage_id',
        'min_amount',
        'max_amount',
        'sequence',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'sequence' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the loan product that owns this workflow.
     */
    public function loanProduct(): BelongsTo
    {
        return $this->belongsTo(LoanProducts::class, 'loan_product_id');
    }

    /**
     * Get the stage associated with this workflow step.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(LoanStages::class, 'stage_id');
    }

    /**
     * Get the workflow steps for a specific loan application based on product and amount.
     *
     * @param int $loanProductId
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getWorkflowForLoan($loanProductId, $amount)
    {
        return self::where('loan_product_id', $loanProductId)
            ->where('min_amount', '<=', $amount)
            ->where('max_amount', '>=', $amount)
            ->where('is_active', true)
            ->orderBy('sequence')
            ->with('stage')
            ->get();
    }
}
