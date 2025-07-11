<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\LoanStages;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StageCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The completed stage.
     *
     * @var \App\Models\LoanStages
     */
    public $stage;

    /**
     * The user who completed the stage.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The action taken (approve, reject, etc.).
     *
     * @var string
     */
    public $action;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\LoanStages  $stage
     * @param  \App\Models\User  $user
     * @param  string  $action
     * @return void
     */
    public function __construct(
        LoanApplications $loanApplication,
        LoanStages $stage,
        User $user,
        string $action
    ) {
        $this->loanApplication = $loanApplication;
        $this->stage = $stage;
        $this->user = $user;
        $this->action = $action;
    }
}
