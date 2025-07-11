<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The loan application ID.
     *
     * @var int
     */
    public $loanApplicationId;

    /**
     * The user who deleted the application.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  int  $loanApplicationId
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($loanApplicationId, User $user)
    {
        $this->loanApplicationId = $loanApplicationId;
        $this->user = $user;
    }
}
