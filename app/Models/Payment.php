<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['billing_cycle_id', 'amount', 'payment_date', 'method'];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function billingCycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }
}