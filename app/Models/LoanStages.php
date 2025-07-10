<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanStages extends Model
{
    /** @use HasFactory<\Database\Factories\LoanStagesFactory> */
    use HasFactory, SoftDeletes;
}
