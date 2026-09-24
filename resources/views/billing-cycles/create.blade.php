<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('billing-cycles.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Billing Cycles</a>
            <span class="text-slate-300">/</span>
            <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Create Cycle</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        
        @if ($subscribers->isEmpty())
            <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-lg shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <p class="text-sm font-medium">You need to add a subscriber before creating a billing cycle.</p>
                </div>
                <a href="{{ route('subscribers.create') }}" class="text-sm font-bold underline hover:text-amber-900">Add Subscriber</a>
            </div>
        @endif

        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white">Manual Billing Cycle</h3>
                    <p class="text-sm text-slate-400">Generate a custom invoice for a specific subscriber.</p>
                </div>

                <form method="POST" action="{{ route('billing-cycles.store') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Subscriber Selection -->
                    <div>
                        <label for="subscriber_id" class="block text-sm font-medium text-slate-300 mb-1">Subscriber</label>
                        <select id="subscriber_id" name="subscriber_id" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <option value="" disabled selected>Select a subscriber...</option>
                            @foreach($subscribers as $subscriber)
                                <option value="{{ $subscriber->id }}" {{ old('subscriber_id') == $subscriber->id ? 'selected' : '' }}>
                                    {{ $subscriber->name }} ({{ $subscriber->plan->name ?? 'No Plan' }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('subscriber_id')" class="mt-2" />
                    </div>

                    <!-- Amount Due -->
                    <div>
                        <label for="amount_due" class="block text-sm font-medium text-slate-300 mb-1">Amount Due (KES)</label>
                        <input id="amount_due" name="amount_due" type="number" step="0.01" value="{{ old('amount_due') }}" required placeholder="0.00"
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm tabular-nums shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('amount_due')" class="mt-2" />
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-slate-300 mb-1">Due Date</label>
                        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', now()->format('Y-m-d')) }}" required
                            style="color-scheme: light;"
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-300 mb-1">Status</label>
                        <select id="status" name="status" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-800 space-x-4">
                        <a href="{{ route('billing-cycles.index') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                        <button type="submit" :disabled="loading" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] disabled:opacity-50">
                            <span x-show="!loading">Create Cycle</span>
                            <span x-show="loading" x-cloak>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>