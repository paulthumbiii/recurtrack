<?php

namespace App\Http\Controllers;

use App\Models\BillingCycle;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingCycleController extends Controller
{
    public function index()
    {
        $billingCycles = BillingCycle::whereHas('subscriber', function ($query) {
            $query->where('business_id', Auth::user()->business_id);
        })->with('subscriber')->orderBy('due_date')->get();

        return view('billing-cycles.index', compact('billingCycles'));
    }

    public function create()
    {
        $subscribers = Auth::user()->business->subscribers()->with('plan')->get();

        return view('billing-cycles.create', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscriber_id' => 'required|exists:subscribers,id',
            'amount_due' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $subscriber = Subscriber::findOrFail($request->subscriber_id);
        $this->authorizeBusinessOwnership($subscriber);

        BillingCycle::create([
            'subscriber_id' => $subscriber->id,
            'amount_due' => $request->amount_due,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('billing-cycles.index')->with('success', 'Billing cycle created.');
    }

    public function edit(BillingCycle $billingCycle)
    {
        $this->authorizeBillingCycleOwnership($billingCycle);

        $subscribers = Auth::user()->business->subscribers;

        return view('billing-cycles.edit', compact('billingCycle', 'subscribers'));
    }

    public function update(Request $request, BillingCycle $billingCycle)
    {
        $this->authorizeBillingCycleOwnership($billingCycle);

        $request->validate([
            'amount_due' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        $billingCycle->update([
            'amount_due' => $request->amount_due,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('billing-cycles.index')->with('success', 'Billing cycle updated.');
    }

    public function destroy(BillingCycle $billingCycle)
    {
        $this->authorizeBillingCycleOwnership($billingCycle);

        $billingCycle->delete();

        return redirect()->route('billing-cycles.index')->with('success', 'Billing cycle deleted.');
    }

    /**
     * Marks a billing cycle as paid and logs a matching Payment record.
     */
    public function markAsPaid(BillingCycle $billingCycle)
    {
        $this->authorizeBillingCycleOwnership($billingCycle);

        $billingCycle->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $billingCycle->payments()->create([
            'amount' => $billingCycle->amount_due,
            'payment_date' => now(),
            'method' => 'cash',
        ]);

        return redirect()->route('billing-cycles.index')->with('success', 'Marked as paid.');
    }

    private function authorizeBusinessOwnership(Subscriber $subscriber): void
    {
        if ($subscriber->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }

    private function authorizeBillingCycleOwnership(BillingCycle $billingCycle): void
    {
        if ($billingCycle->subscriber->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}