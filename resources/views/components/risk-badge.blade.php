@props(['level'])

@php
    $level = strtolower($level);
    
    $bgTextClass = match($level) {
        'low'    => 'bg-emerald-100 text-emerald-800',
        'medium' => 'bg-amber-100 text-amber-800',
        'high'   => 'bg-rose-100 text-rose-800',
        default  => 'bg-slate-100 text-slate-800',
    };

    $dotClass = match($level) {
        'low'    => 'bg-emerald-500',
        'medium' => 'bg-amber-500',
        'high'   => 'bg-rose-500',
        default  => 'bg-slate-500',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgTextClass }}">
    <span class="w-2 h-2 rounded-full mr-1.5 {{ $dotClass }}"></span>
    {{ ucfirst($level) }}
</span>