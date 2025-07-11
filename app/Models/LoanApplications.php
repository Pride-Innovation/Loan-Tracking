<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanApplications extends Model
{
    /** @use HasFactory<\Database\Factories\LoanApplicationsFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_number',
        'customer_name',
        'customer_reference',
        'amount',
        'branch_id',
        'region_id',
        'relationship_officer_id',
        'loan_product_id',
        'current_stage_id',
        'status',
        'application_date',
        'description',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'application_date' => 'datetime',
    ];

    /**
     * Get the branch that the loan application belongs to.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    /**
     * Get the region that the loan application belongs to.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Regions::class, 'region_id');
    }

    /**
     * Get the relationship officer that the loan application belongs to.
     */
    public function relationshipOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'relationship_officer_id');
    }

    /**
     * Get the loan product that the loan application belongs to.
     */
    public function loanProduct(): BelongsTo
    {
        return $this->belongsTo(LoanProducts::class, 'loan_product_id');
    }

    /**
     * Get the current stage of the loan application.
     */
    public function currentStage(): BelongsTo
    {
        return $this->belongsTo(LoanStages::class, 'current_stage_id');
    }

    /**
     * Get all stage assignments for this loan application.
     */
    public function stageAssignments(): HasMany
    {
        return $this->hasMany(StageAssignments::class, 'loan_application_id');
    }

    /**
     * Get all stage history records for this loan application.
     */
    public function stageHistory(): HasMany
    {
        return $this->hasMany(LoanStageHistory::class, 'loan_application_id');
    }

    /**
     * Get all SLA escalations for this loan application.
     */
    public function slaEscalations(): HasMany
    {
        return $this->hasMany(SlaNotifications::class, 'loan_application_id');
    }

    /**
     * Get all notifications for this loan application.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, 'loan_application_id');
    }
}
