<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\LoanStages;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SLAWarning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The stage with an SLA warning.
     *
     * @var \App\Models\LoanStages
     */
    public $stage;

    /**
     * Hours overdue.
     *
     * @var int
     */
    public $hoursOverdue;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\LoanStages  $stage
     * @param  int  $hoursOverdue
     * @return void
     */
    public function __construct(
        LoanApplications $loanApplication,
        LoanStages $stage,
        int $hoursOverdue
    ) {
        $this->loanApplication = $loanApplication;
        $this->stage = $stage;
        $this->hoursOverdue = $hoursOverdue;
    }
}
