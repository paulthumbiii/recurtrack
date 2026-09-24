<?php

namespace App\Http\Controllers;

use App\Models\ChurnInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsightController extends Controller
{
    public function index()
    {
        // 1. Fetch all insights for this business's subscribers, newest first
        $allInsights = ChurnInsight::with(['subscriber.plan'])
            ->whereHas('subscriber', function($query) {
                $query->where('business_id', Auth::user()->business_id);
            })
            ->orderBy('generated_at', 'desc')
            ->get();

        // 2. Keep only the MOST RECENT insight per subscriber using collection unique()
        $latestInsights = $allInsights->unique('subscriber_id');

        // 3. Group by risk level for the tabs
        $highRisk   = $latestInsights->where('risk_level', 'high')->values();
        $mediumRisk = $latestInsights->where('risk_level', 'medium')->values();
        $lowRisk    = $latestInsights->where('risk_level', 'low')->values();

        return view('insights.index', compact('highRisk', 'mediumRisk', 'lowRisk', 'latestInsights'));
    }
}