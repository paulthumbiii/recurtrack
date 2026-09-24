<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-white">Welcome back</h2>
        <p class="text-sm text-slate-400 mt-1">Sign in to manage your recurring revenue.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full rounded-lg bg-white text-slate-900 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm transition-shadow">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-800 text-indigo-500 shadow-sm focus:ring-indigo-500 focus:ring-offset-slate-900">
                <span class="ml-2 text-sm text-slate-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" :disabled="loading" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-[0_0_15px_rgba(99,102,241,0.4)] text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-400 hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition-all disabled:opacity-50">
                <span x-show="!loading">Log In</span>
                <span x-show="loading" x-cloak>Logging in...</span>
            </button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center text-sm text-slate-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Start Free</a>
        </div>
    </form>
</x-guest-layout>