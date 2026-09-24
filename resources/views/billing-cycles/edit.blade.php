<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('billing-cycles.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Billing Cycles</a>
            <span class="text-slate-300">/</span>
            <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Edit Cycle</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-white">Update Invoice</h3>
                        <p class="text-sm text-slate-400">Modify billing details for this cycle.</p>
                    </div>
                    <x-status-badge :status="$billingCycle->status" type="billing" />
                </div>

                <form method="POST" action="{{ route('billing-cycles.update', $billingCycle) }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    <!-- Subscriber (Disabled, visual only) -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Subscriber</label>
                        <input type="text" value="{{ $billingCycle->subscriber->name }}" disabled
                            class="block w-full rounded-lg bg-slate-100 text-slate-500 border-slate-300 cursor-not-allowed text-sm shadow-sm">
                        <!-- Hidden field to preserve ID -->
                        <input type="hidden" name="subscriber_id" value="{{ $billingCycle->subscriber_id }}">
                    </div>

                    <!-- Amount Due -->
                    <div>
                        <label for="amount_due" class="block text-sm font-medium text-slate-300 mb-1">Amount Due (KES)</label>
                        <input id="amount_due" name="amount_due" type="number" step="0.01" value="{{ old('amount_due', $billingCycle->amount_due) }}" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm tabular-nums shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('amount_due')" class="mt-2" />
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-slate-300 mb-1">Due Date</label>
                        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $billingCycle->due_date->format('Y-m-d')) }}" required
                            style="color-scheme: light;"
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-300 mb-1">Status</label>
                        <select id="status" name="status" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <option value="pending" {{ old('status', $billingCycle->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('status', $billingCycle->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ old('status', $billingCycle->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-800">
                        <button type="button" onclick="if(confirm('Delete this billing cycle? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }" class="text-sm font-medium text-rose-400 hover:text-rose-300 transition-colors">
                            Delete Cycle
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('billing-cycles.index') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                            <button type="submit" :disabled="loading" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] disabled:opacity-50">
                                <span x-show="!loading">Save Changes</span>
                                <span x-show="loading" x-cloak>Saving...</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="delete-form" action="{{ route('billing-cycles.destroy', $billingCycle) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>