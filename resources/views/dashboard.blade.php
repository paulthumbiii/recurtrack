<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-metric-card label="Monthly Recurring Revenue" value="KES {{ number_format($mrr, 2) }}" />
        <x-metric-card label="Active Subscribers" value="{{ $activeSubscribersCount }}" />
        <x-metric-card
            label="Overdue Billing Cycles"
            value="{{ $overdueCount }}"
            :trend="$overdueCount > 0 ? 'Needs attention' : null"
            :trend-up="false"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

        <!-- Revenue trend chart -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4">Revenue Trend — Last 6 Months</p>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        <!-- Overdue list widget -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4">Overdue Accounts</p>

            @forelse ($overdueCycles as $cycle)
                <div class="flex justify-between items-start py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                    <div>
                        <p class="text-sm font-medium text-slate-900">{{ $cycle->subscriber->name }}</p>
                        <p class="text-xs text-slate-500">Due {{ \Carbon\Carbon::parse($cycle->due_date)->format('d M Y') }}</p>
                    </div>
                    <p class="text-sm font-semibold text-rose-600 tabular-nums">
                        KES {{ number_format($cycle->amount_due, 2) }}
                    </p>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-slate-500">No overdue accounts</p>
                </div>
            @endforelse
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json(collect($revenueTrend)->pluck('month')),
                    datasets: [{
                        label: 'Revenue',
                        data: @json(collect($revenueTrend)->pluck('total')),
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                        pointBackgroundColor: '#4F46E5',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
    @endpush

</x-app-layout>