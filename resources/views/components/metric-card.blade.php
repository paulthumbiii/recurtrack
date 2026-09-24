@props(['label', 'value', 'trend' => null, 'trendUp' => true])

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $label }}</p>
    <p class="text-3xl font-bold text-slate-900 tabular-nums mt-2">{{ $value }}</p>
    
    @if($trend)
        <p class="text-xs mt-2 {{ $trendUp ? 'text-emerald-600' : 'text-rose-600' }} font-medium flex items-center">
            @if($trendUp)
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                </svg>
            @else
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25" />
                </svg>
            @endif
            {{ $trend }}
        </p>
    @endif
</div>