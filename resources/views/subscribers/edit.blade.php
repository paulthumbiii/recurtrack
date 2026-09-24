<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('subscribers.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Subscribers</a>
            <span class="text-slate-300">/</span>
            <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Edit Subscriber</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-4">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-white">Edit Profile</h3>
                        <p class="text-sm text-slate-400">Update details for {{ $subscriber->name }}.</p>
                    </div>
                    <x-status-badge :status="$subscriber->status" type="subscriber" />
                </div>

                <form method="POST" action="{{ route('subscribers.update', $subscriber) }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $subscriber->name) }}" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $subscriber->email) }}"
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-300 mb-1">Phone</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $subscriber->phone) }}"
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="plan_id" class="block text-sm font-medium text-slate-300 mb-1">Assigned Plan</label>
                        <select id="plan_id" name="plan_id" required
                            class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('plan_id', $subscriber->plan_id) == $plan->id)>
                                    {{ $plan->name }} — KES {{ number_format($plan->price, 2) }} ({{ $plan->billing_frequency }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-300 mb-1">Account Status</label>
                            <select id="status" name="status" required
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                                <option value="active" @selected(old('status', $subscriber->status) == 'active')>Active</option>
                                <option value="paused" @selected(old('status', $subscriber->status) == 'paused')>Paused</option>
                                <option value="cancelled" @selected(old('status', $subscriber->status) == 'cancelled')>Cancelled</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-300 mb-1">Start Date</label>
                            <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $subscriber->start_date->format('Y-m-d')) }}" required
                                style="color-scheme: light;"
                                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-800">
                        <button type="button" onclick="if(confirm('Delete this subscriber? All billing history will also be lost.')) { document.getElementById('delete-form').submit(); }" class="text-sm font-medium text-rose-400 hover:text-rose-300 transition-colors">
                            Delete Subscriber
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('subscribers.index') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                            <button type="submit" :disabled="loading" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] disabled:opacity-50">
                                <span x-show="!loading">Save Changes</span>
                                <span x-show="loading" x-cloak>Saving...</span>
                            </button>
                        </div>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('subscribers.destroy', $subscriber) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>