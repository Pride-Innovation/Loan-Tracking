<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanStageHistory extends Model
{
    /** @use HasFactory<\Database\Factories\LoanStageHistoryFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_application_id',
        'loan_stage_id',
        'user_id',
        'action',
        'comments',
        'time_spent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time_spent' => 'integer', // Time spent in minutes
    ];

    /**
     * Action constants
     */
    const ACTION_STARTED = 'started';
    const ACTION_COMPLETED = 'completed';
    const ACTION_RETURNED = 'returned';
    const ACTION_REJECTED = 'rejected';
    const ACTION_ESCALATED = 'escalated';

    /**
     * Get the loan application associated with this history record.
     */
    public function loanApplication(): BelongsTo
    {
        return $this->belongsTo(LoanApplications::class, 'loan_application_id');
    }

    /**
     * Get the loan stage associated with this history record.
     */
    public function loanStage(): BelongsTo
    {
        return $this->belongsTo(LoanStages::class, 'loan_stage_id');
    }

    /**
     * Get the user who performed this action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
