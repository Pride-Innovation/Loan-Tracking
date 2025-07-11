<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanStages extends Model
{
    /** @use HasFactory<\Database\Factories\LoanStagesFactory> */
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'order',
        'sla_days',
        'is_final',
        'required_role',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'sla_days' => 'integer',
        'is_final' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the loan applications currently in this stage.
     */
    public function loanApplications(): HasMany
    {
        return $this->hasMany(LoanApplications::class, 'current_stage_id');
    }

    /**
     * Get all workflows that include this stage.
     */
    public function approvalWorkflows(): HasMany
    {
        return $this->hasMany(ApprovalWorkFlows::class, 'stage_id');
    }

    /**
     * Get all stage assignments for this stage.
     */
    public function stageAssignments(): HasMany
    {
        return $this->hasMany(StageAssignments::class, 'loan_stage_id');
    }

    /**
     * Get all stage history records for this stage.
     */
    public function stageHistory(): HasMany
    {
        return $this->hasMany(LoanStageHistory::class, 'loan_stage_id');
    }

    /**
     * Get all SLA escalations where this stage is the current stage.
     */
    public function slaEscalationsFrom(): HasMany
    {
        return $this->hasMany(SlaNotifications::class, 'current_stage_id');
    }

    /**
     * Get all SLA escalations where this stage is the escalated-to stage.
     */
    public function slaEscalationsTo(): HasMany
    {
        return $this->hasMany(SlaNotifications::class, 'escalated_to_stage_id');
    }

    /**
     * Get the next stage in sequence.
     */
    public function getNextStage()
    {
        return self::where('order', '>', $this->order)
            ->where('is_active', true)
            ->orderBy('order')
            ->first();
    }
}
