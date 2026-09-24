<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurnInsight extends Model
{
    use HasFactory;

    protected $fillable = ['subscriber_id', 'risk_level', 'narrative', 'generated_at'];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}