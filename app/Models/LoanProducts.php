<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanProducts extends Model
{
    /** @use HasFactory<\Database\Factories\LoanProductsFactory> */
    use HasFactory, SoftDeletes;
}
