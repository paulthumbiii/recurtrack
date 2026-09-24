<?php

namespace App\Notifications;

use App\Models\BillingCycle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillingCycleOverdue extends Notification
{
    use Queueable;

    public function __construct(protected BillingCycle $billingCycle)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subscriber = $this->billingCycle->subscriber;

        return (new MailMessage)
            ->subject("Overdue Payment: {$subscriber->name}")
            ->greeting("Hi {$notifiable->name},")
            ->line("{$subscriber->name}'s payment of KES ".number_format($this->billingCycle->amount_due, 2)." is now overdue.")
            ->line('Due date was: '.$this->billingCycle->due_date->format('d M Y'))
            ->action('View Billing Cycles', route('billing-cycles.index'))
            ->line('Consider reaching out to them directly.');
    }
}