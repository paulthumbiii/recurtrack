<x-app-layout>
    <x-slot name="header">
        Subscribers
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-slate-500">Everyone currently subscribed to one of your plans.</p>
        <a href="{{ route('subscribers.create') }}" class="bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-indigo-700 transition-colors">
            + Add Subscriber
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Start Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($subscribers as $subscriber)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $subscriber->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $subscriber->plan->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $subscriber->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <x-status-badge :status="$subscriber->status" type="subscriber" />
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $subscriber->start_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('subscribers.edit', $subscriber) }}" class="text-indigo-600 hover:text-indigo-800 font-medium mr-4">Edit</a>
                            <form action="{{ route('subscribers.destroy', $subscriber) }}" method="POST" class="inline" onsubmit="return confirm('Remove this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>
                            <p class="text-sm text-slate-500 mb-4">No subscribers yet. Add your first one.</p>
                            <a href="{{ route('subscribers.create') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">+ Add Subscriber</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>