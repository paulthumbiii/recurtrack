<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('plans.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Plans</a>
            <span class="text-slate-300">/</span>
            <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Edit Plan</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white">Update Plan</h3>
                    <p class="text-sm text-slate-400">Modify the settings for {{ $plan->name }}.</p>
                </div>

                <form method="POST" action="{{ route('plans.update', $plan) }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Plan Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $plan->name) }}" required autofocus
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-300 mb-1">Price (KES)</label>
                        <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $plan->price) }}" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm tabular-nums shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div>
                        <label for="billing_frequency" class="block text-sm font-medium text-slate-300 mb-1">Billing Frequency</label>
                        <select id="billing_frequency" name="billing_frequency" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <option value="weekly" {{ old('billing_frequency', $plan->billing_frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('billing_frequency', $plan->billing_frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="annually" {{ old('billing_frequency', $plan->billing_frequency) == 'annually' ? 'selected' : '' }}>Annually</option>
                        </select>
                        <x-input-error :messages="$errors->get('billing_frequency')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-800">
                        <button type="button" onclick="if(confirm('Delete this plan? Subscribers on this plan will also be affected.')) { document.getElementById('delete-form').submit(); }" class="text-sm font-medium text-rose-400 hover:text-rose-300 transition-colors">
                            Delete Plan
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('plans.index') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                            <button type="submit" :disabled="loading" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] disabled:opacity-50">
                                <span x-show="!loading">Save Changes</span>
                                <span x-show="loading" x-cloak>Saving...</span>
                            </button>
                        </div>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('plans.destroy', $plan) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>