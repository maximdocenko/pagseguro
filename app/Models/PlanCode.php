<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCode extends Model
{
    use HasFactory;

    protected $table = 'plan_codes';

    protected $guarded = [];
}
