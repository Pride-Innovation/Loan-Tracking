<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanStageHistory extends Model
{
    /** @use HasFactory<\Database\Factories\LoanStageHistoryFactory> */
    use HasFactory, SoftDeletes;
}
