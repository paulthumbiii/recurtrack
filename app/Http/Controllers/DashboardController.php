<?php

namespace App\Http\Controllers;

use App\Models\BillingCycle;
use App\Models\Payment;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $businessId = Auth::user()->business_id;

        $mrr = $this->calculateMrr($businessId);
        $activeSubscribersCount = Subscriber::where('business_id', $businessId)
            ->where('status', 'active')
            ->count();

        $overdueCount = BillingCycle::whereHas('subscriber', function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->where('status', 'overdue')->count();

        $overdueCycles = BillingCycle::whereHas('subscriber', function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->where('status', 'overdue')->with('subscriber')->get();

        $revenueTrend = $this->getRevenueTrend($businessId);

        return view('dashboard', compact(
            'mrr',
            'activeSubscribersCount',
            'overdueCount',
            'overdueCycles',
            'revenueTrend'
        ));
    }

    /**
     * MRR = sum of active subscribers' plan prices,
     * normalized to a monthly figure regardless of billing frequency.
     */
    private function calculateMrr(int $businessId): float
    {
        $activeSubscribers = Subscriber::where('business_id', $businessId)
            ->where('status', 'active')
            ->with('plan')
            ->get();

        return $activeSubscribers->sum(function ($subscriber) {
            return match ($subscriber->plan->billing_frequency) {
                'weekly' => $subscriber->plan->price * 4.33,
                'monthly' => $subscriber->plan->price,
                'annually' => $subscriber->plan->price / 12,
                default => $subscriber->plan->price,
            };
        });
    }

    /**
     * Total payments received per month, for the last 6 months.
     */
    private function getRevenueTrend(int $businessId): array
    {
        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            return Carbon::now()->subMonths($monthsAgo)->startOfMonth();
        });

        $trend = [];

        foreach ($months as $month) {
            $total = Payment::whereHas('billingCycle.subscriber', function ($query) use ($businessId) {
                $query->where('business_id', $businessId);
            })
            ->whereYear('payment_date', $month->year)
            ->whereMonth('payment_date', $month->month)
            ->sum('amount');

            $trend[] = [
                'month' => $month->format('M Y'),
                'total' => (float) $total,
            ];
        }

        return $trend;
    }
}