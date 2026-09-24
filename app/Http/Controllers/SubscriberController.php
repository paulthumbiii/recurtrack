<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Auth::user()->business->subscribers()->with('plan')->get();

        return view('subscribers.index', compact('subscribers'));
    }

    public function create()
    {
        $plans = Auth::user()->business->plans;

        return view('subscribers.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
        ]);

        Auth::user()->business->subscribers()->create([
            'plan_id' => $request->plan_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 'active',
            'start_date' => $request->start_date,
        ]);

        return redirect()->route('subscribers.index')->with('success', 'Subscriber added successfully.');
    }

    public function edit(Subscriber $subscriber)
    {
        $this->authorizeBusinessOwnership($subscriber);

        $plans = Auth::user()->business->plans;

        return view('subscribers.edit', compact('subscriber', 'plans'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $this->authorizeBusinessOwnership($subscriber);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,paused,cancelled',
            'start_date' => 'required|date',
        ]);

        $subscriber->update([
            'plan_id' => $request->plan_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'start_date' => $request->start_date,
        ]);

        return redirect()->route('subscribers.index')->with('success', 'Subscriber updated successfully.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $this->authorizeBusinessOwnership($subscriber);

        $subscriber->delete();

        return redirect()->route('subscribers.index')->with('success', 'Subscriber removed.');
    }

    private function authorizeBusinessOwnership(Subscriber $subscriber): void
    {
        if ($subscriber->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}