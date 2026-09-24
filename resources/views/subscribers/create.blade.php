<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('subscribers.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Subscribers</a>
            <span class="text-slate-300">/</span>
            <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Add Subscriber</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        
        @if ($plans->isEmpty())
            <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-lg shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <p class="text-sm font-medium">You need to create a plan before adding subscribers.</p>
                </div>
                <a href="{{ route('plans.create') }}" class="text-sm font-bold underline hover:text-amber-900">Create Plan</a>
            </div>
        @endif

        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white">Subscriber Profile</h3>
                    <p class="text-sm text-slate-400">Enter the customer details and assign their billing plan.</p>
                </div>

                <form method="POST" action="{{ route('subscribers.store') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email (Optional)</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-300 mb-1">Phone (Optional)</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="plan_id" class="block text-sm font-medium text-slate-300 mb-1">Assigned Plan</label>
                        <select id="plan_id" name="plan_id" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <option value="" disabled selected>Select a plan...</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                                    {{ $plan->name }} — KES {{ number_format($plan->price, 2) }} ({{ $plan->billing_frequency }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-300 mb-1">Start Date</label>
                        <input id="start_date" name="start_date" type="date" value="{{ old('start_date', date('Y-m-d')) }}" required
                            style="color-scheme: light;"
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-800 space-x-4">
                        <a href="{{ route('subscribers.index') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                        <button type="submit" :disabled="loading" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] disabled:opacity-50">
                            <span x-show="!loading">Save Subscriber</span>
                            <span x-show="loading" x-cloak>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>