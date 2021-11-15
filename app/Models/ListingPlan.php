<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPlan extends Model
{
    use HasFactory;

    protected $table = 'listing_plans';

    protected $guarded = [];

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
}
