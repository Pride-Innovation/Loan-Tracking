<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalWorkFlows extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalWorkFlowsFactory> */
    use HasFactory, SoftDeletes;
}
