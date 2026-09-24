@props(['status', 'type' => 'subscriber'])

@php
    $status = strtolower($status);
    $color = 'slate'; // Default fallback

    if ($type === 'subscriber') {
        $color = match($status) {
            'active' => 'emerald',
            'paused' => 'amber',
            'cancelled' => 'rose',
            default => 'slate',
        };
    } elseif ($type === 'billing') {
        $color = match($status) {
            'paid' => 'emerald',
            'pending' => 'amber',
            'overdue' => 'rose',
            default => 'slate',
        };
    }

    $classes = match($color) {
        'emerald' => 'bg-emerald-100 text-emerald-800',
        'amber'   => 'bg-amber-100 text-amber-800',
        'rose'    => 'bg-rose-100 text-rose-800',
        default   => 'bg-slate-100 text-slate-800',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst($status) }}
</span>