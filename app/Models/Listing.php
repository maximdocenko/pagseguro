<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'listings';

    protected $guarded = [];

    public function listing_plan()
    {
        return $this->hasOne(ListingPlan::class);
    }
}
