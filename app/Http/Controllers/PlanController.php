<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Auth::user()->business->plans;

        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_frequency' => 'required|in:weekly,monthly,annually',
        ]);

        Auth::user()->business->plans()->create([
            'name' => $request->name,
            'price' => $request->price,
            'billing_frequency' => $request->billing_frequency,
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $this->authorizeBusinessOwnership($plan);

        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $this->authorizeBusinessOwnership($plan);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_frequency' => 'required|in:weekly,monthly,annually',
        ]);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'billing_frequency' => $request->billing_frequency,
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $this->authorizeBusinessOwnership($plan);

        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan deleted.');
    }

    /**
     * Simple manual multi-tenancy check: make sure the plan
     * actually belongs to the logged-in user's business.
     */
    private function authorizeBusinessOwnership(Plan $plan): void
    {
        if ($plan->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}