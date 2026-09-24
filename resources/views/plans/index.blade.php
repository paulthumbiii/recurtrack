<x-app-layout>
    <x-slot name="header">
        Plans
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-slate-500">Manage the pricing plans your subscribers pay into.</p>
        <a href="{{ route('plans.create') }}" class="bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-indigo-700 transition-colors">
            + Add New Plan
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Billing Frequency</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($plans as $plan)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $plan->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700 tabular-nums">KES {{ number_format($plan->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700 capitalize">{{ $plan->billing_frequency }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-800 font-medium mr-4">Edit</a>
                            <form action="{{ route('plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Delete this plan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-sm text-slate-500 mb-4">No plans yet. Create your first one.</p>
                            <a href="{{ route('plans.create') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">+ Add New Plan</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>