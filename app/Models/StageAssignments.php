<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StageAssignments extends Model
{
    /** @use HasFactory<\Database\Factories\StageAssignmentsFactory> */
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
        'assigned_by',
        'status',
        'due_date',
        'completed_at',
        'comments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_OVERDUE = 'overdue';

    /**
     * Get the loan application associated with this assignment.
     */
    public function loanApplication(): BelongsTo
    {
        return $this->belongsTo(LoanApplications::class, 'loan_application_id');
    }

    /**
     * Get the loan stage associated with this assignment.
     */
    public function loanStage(): BelongsTo
    {
        return $this->belongsTo(LoanStages::class, 'loan_stage_id');
    }

    /**
     * Get the user assigned to this stage.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who made this assignment.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Scope a query to only include assignments for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include pending assignments.
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_IN_PROGRESS]);
    }

    /**
     * Scope a query to only include overdue assignments.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE)
            ->orWhere(function ($query) {
                $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_IN_PROGRESS])
                    ->where('due_date', '<', now());
            });
    }
}
