<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $guarded = [];

    public function plan_code()
    {
        return $this->hasOne(PlanCode::class);
    }
}
