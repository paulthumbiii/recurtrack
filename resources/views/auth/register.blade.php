<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-white">Create your account</h2>
        <p class="text-sm text-slate-400 mt-1">Start managing your business subscriptions.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Business Name (Custom Field) -->
        <div>
            <label for="business_name" class="block text-sm font-medium text-slate-300 mb-1">Business Name</label>
            <input id="business_name" type="text" name="business_name" value="{{ old('business_name') }}" required autofocus autocomplete="organization" placeholder="e.g. FitLife Gym"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
        </div>

        <!-- Owner Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Your Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" :disabled="loading" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-[0_0_15px_rgba(99,102,241,0.4)] text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-400 hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition-all disabled:opacity-50">
                <span x-show="!loading">Create Account</span>
                <span x-show="loading" x-cloak>Registering...</span>
            </button>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center text-sm text-slate-400">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Log in</a>
        </div>
    </form>
</x-guest-layout>