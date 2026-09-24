<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'plan_id', 'name', 'phone', 'email', 'status', 'start_date'];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function billingCycles()
    {
        return $this->hasMany(BillingCycle::class);
    }

    public function churnInsights()
    {
        return $this->hasMany(ChurnInsight::class);
    }
}