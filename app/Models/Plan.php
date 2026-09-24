<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'price', 'billing_frequency'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}