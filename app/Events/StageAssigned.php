<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\LoanStages;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StageAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The stage being assigned.
     *
     * @var \App\Models\LoanStages
     */
    public $stage;

    /**
     * The assigned users (array of user IDs or User models).
     *
     * @var array
     */
    public $assignedUsers;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\LoanStages  $stage
     * @param  array  $assignedUsers
     * @return void
     */
    public function __construct(
        LoanApplications $loanApplication,
        LoanStages $stage,
        array $assignedUsers
    ) {
        $this->loanApplication = $loanApplication;
        $this->stage = $stage;
        $this->assignedUsers = $assignedUsers;
    }
}
