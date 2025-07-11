<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The user who created the application.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(LoanApplications $loanApplication, User $user)
    {
        $this->loanApplication = $loanApplication;
        $this->user = $user;
    }
}
