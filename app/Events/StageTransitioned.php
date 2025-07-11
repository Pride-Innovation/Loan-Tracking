<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\LoanStages;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StageTransitioned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The source stage.
     *
     * @var \App\Models\LoanStages|null
     */
    public $fromStage;

    /**
     * The destination stage.
     *
     * @var \App\Models\LoanStages
     */
    public $toStage;

    /**
     * The user who transitioned the stage.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The comment associated with the transition.
     *
     * @var string|null
     */
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\LoanStages|null  $fromStage
     * @param  \App\Models\LoanStages  $toStage
     * @param  \App\Models\User  $user
     * @param  string|null  $comment
     * @return void
     */
    public function __construct(
        LoanApplications $loanApplication,
        ?LoanStages $fromStage,
        LoanStages $toStage,
        User $user,
        ?string $comment = null
    ) {
        $this->loanApplication = $loanApplication;
        $this->fromStage = $fromStage;
        $this->toStage = $toStage;
        $this->user = $user;
        $this->comment = $comment;
    }
}
