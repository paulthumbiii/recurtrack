<x-app-layout>
    <x-slot name="header">
        Billing Cycles
    </x-slot>

    <!-- Top Action Bar (Matches Subscribers pattern) -->
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-slate-500">Manage all pending, paid, and overdue billing cycles.</p>
        <a href="{{ route('billing-cycles.create') }}" class="bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            New Cycle
        </a>
    </div>

    <!-- Success Message (Added this to match Subscribers too!) -->
    @if (session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subscriber</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Amount Due</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($billingCycles as $cycle)
                        <tr class="{{ $cycle->status === 'overdue' ? 'bg-rose-50/50 hover:bg-rose-50' : 'hover:bg-slate-50' }} transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $cycle->subscriber->name }}</div>
                                <div class="text-xs text-slate-500">{{ $cycle->subscriber->plan->name ?? 'Unknown Plan' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ $cycle->due_date->format('d M Y') }}</div>
                                @if($cycle->paid_at)
                                    <div class="text-xs text-emerald-600 mt-0.5">Paid: {{ $cycle->paid_at->format('d M Y') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold text-slate-900 tabular-nums">KES {{ number_format($cycle->amount_due, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$cycle->status" type="billing" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- Mark as Paid Action -->
                                    @if($cycle->status !== 'paid')
                                        <form action="{{ route('billing-cycles.mark-as-paid', $cycle) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" :disabled="loading" class="text-indigo-600 hover:text-indigo-900 disabled:opacity-50 transition-opacity">
                                                <span x-show="!loading">Mark Paid</span>
                                                <span x-show="loading" x-cloak>Processing...</span>
                                            </button>
                                        </form>
                                        <span class="text-slate-300">|</span>
                                    @endif
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('billing-cycles.edit', $cycle) }}" class="text-slate-500 hover:text-slate-900 transition-colors">Edit</a>
                                    
                                    <!-- Delete -->
                                    <form action="{{ route('billing-cycles.destroy', $cycle) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this billing cycle? This cannot be undone.');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 transition-colors ml-3">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-900">No billing cycles yet</p>
                                    <p class="text-sm text-slate-500 mt-1 max-w-sm">Billing cycles are generated automatically based on active subscriber plans. You can also manually create one.</p>
                                    <a href="{{ route('billing-cycles.create') }}" class="mt-4 bg-white border border-slate-300 text-slate-700 rounded-lg px-4 py-2 text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                                        + Create Manual Cycle
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (if applicable) -->
        @if(method_exists($billingCycles, 'links') && $billingCycles->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $billingCycles->links() }}
            </div>
        @endif
    </div>
</x-app-layout>