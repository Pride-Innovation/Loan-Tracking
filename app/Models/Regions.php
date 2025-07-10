<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regions extends Model
{
    /** @use HasFactory<\Database\Factories\RegionsFactory> */
    use HasFactory, SoftDeletes;
}
