<?php

namespace App\Events;

use App\Models\LoanApplications;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application instance.
     *
     * @var \App\Models\LoanApplications
     */
    public $loanApplication;

    /**
     * The user who updated the application.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The attributes that were changed.
     *
     * @var array
     */
    public $changes;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\LoanApplications  $loanApplication
     * @param  \App\Models\User  $user
     * @param  array  $changes
     * @return void
     */
    public function __construct(LoanApplications $loanApplication, User $user, array $changes)
    {
        $this->loanApplication = $loanApplication;
        $this->user = $user;
        $this->changes = $changes;
    }
}
