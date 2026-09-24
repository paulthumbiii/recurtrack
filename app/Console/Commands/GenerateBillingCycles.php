<?php

namespace App\Console\Commands;

use App\Models\BillingCycle;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateBillingCycles extends Command
{
    protected $signature = 'billing:generate-cycles';

    protected $description = 'Generates due billing cycles for active subscribers and flags overdue ones.';

    public function handle(): void
    {
        $this->generateDueCycles();
        $this->flagOverdueCycles();

        $this->info('Billing cycle generation complete.');
    }

    private function generateDueCycles(): void
    {
        $subscribers = Subscriber::where('status', 'active')->with('plan', 'billingCycles')->get();

        foreach ($subscribers as $subscriber) {
            $lastCycle = $subscriber->billingCycles->sortByDesc('due_date')->first();

            $nextDueDate = $lastCycle
                ? $this->addInterval(Carbon::parse($lastCycle->due_date), $subscriber->plan->billing_frequency)
                : Carbon::parse($subscriber->start_date);

            if ($nextDueDate->lessThanOrEqualTo(now())) {
                $alreadyExists = $subscriber->billingCycles->contains(
                    fn ($cycle) => Carbon::parse($cycle->due_date)->isSameDay($nextDueDate)
                );

                if (! $alreadyExists) {
                    BillingCycle::create([
                        'subscriber_id' => $subscriber->id,
                        'amount_due' => $subscriber->plan->price,
                        'due_date' => $nextDueDate,
                        'status' => 'pending',
                    ]);

                    $this->line("Created billing cycle for {$subscriber->name}, due {$nextDueDate->format('d M Y')}");
                }
            }
        }
    }

   private function flagOverdueCycles(): void
{
    $cyclesToFlag = BillingCycle::where('status', 'pending')
        ->where('due_date', '<', now()->toDateString())
        ->with('subscriber.business.users')
        ->get();

    foreach ($cyclesToFlag as $cycle) {
        $cycle->update(['status' => 'overdue']);

        $business = $cycle->subscriber->business;

        foreach ($business->users as $user) {
            $user->notify(new \App\Notifications\BillingCycleOverdue($cycle));
        }
    }

    if ($cyclesToFlag->count() > 0) {
        $this->line("Flagged {$cyclesToFlag->count()} billing cycle(s) as overdue and notified business owner(s).");
    }
}
    private function addInterval(Carbon $date, string $frequency): Carbon
    {
        return match ($frequency) {
            'weekly' => $date->addWeek(),
            'monthly' => $date->addMonth(),
            'annually' => $date->addYear(),
            default => $date->addMonth(),
        };
    }
}