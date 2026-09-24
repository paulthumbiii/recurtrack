@props(['insight'])

@php
    $level = strtolower($insight->risk_level);
    
    $borderColor = match($level) {
        'low'    => 'border-emerald-500',
        'medium' => 'border-amber-500',
        'high'   => 'border-rose-500',
        default  => 'border-slate-200', // fallback
    };
@endphp

<div class="bg-white rounded-xl border-l-4 {{ $borderColor }} border-t border-r border-b border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
    <div class="flex justify-between items-start">
        <div>
            <h4 class="font-semibold text-slate-900">{{ $insight->subscriber->name ?? 'Unknown Subscriber' }}</h4>
            <p class="text-xs text-slate-500 mt-0.5">
                {{ $insight->subscriber->plan->name ?? 'Unknown Plan' }} &middot; Flagged {{ $insight->generated_at->diffForHumans() }}
            </p>
        </div>
        
        <x-risk-badge :level="$insight->risk_level" />
    </div>
    
    <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mt-4 text-sm text-slate-700 italic">
        "{{ $insight->narrative }}"
    </div>
</div>