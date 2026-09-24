<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'RecurTrack') }} - Subscription Management & AI Insights</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-900 text-slate-300 selection:bg-indigo-500 selection:text-white">

    <!-- Navigation -->
    <nav class="absolute top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-2xl font-extrabold text-white tracking-tight">Recur<span class="text-indigo-400">Track</span></span>
            </div>
            
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-4 py-2 text-sm font-medium transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)]">
                            Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20 pb-12">
        
        <!-- Glowing Background Effects -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-600 via-purple-600 to-violet-600 rounded-full blur-[120px] opacity-20"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8">
                Automate Billing. <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Predict Churn with AI.</span>
            </h1>
            
            <p class="mt-4 text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                The all-in-one recurring revenue platform for modern businesses. Manage subscribers, track overdue payments, and let Google Gemini flag high-risk customers before they cancel.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg px-8 py-4 text-base font-semibold transition-all shadow-[0_0_15px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)]">
                        Create Your Account
                    </a>
                @endif
                <a href="#features" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 text-white rounded-lg px-8 py-4 text-base font-semibold transition-colors border border-slate-700">
                    Explore Features
                </a>
            </div>
        </div>
    </main>

    <!-- Features Grid -->
    <section id="features" class="py-24 bg-slate-900 border-t border-slate-800 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                
                <!-- Feature 1 -->
                <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50">
                    <div class="w-12 h-12 rounded-lg bg-indigo-500/10 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Automated Cycles</h3>
                    <p class="text-slate-400 leading-relaxed">System-generated invoices based on weekly, monthly, or annual subscription plans. Set it and forget it.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50 relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-12 h-12 rounded-lg bg-purple-500/10 flex items-center justify-center mb-6 relative">
                        <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 relative">AI Churn Insights</h3>
                    <p class="text-slate-400 leading-relaxed relative">Google Gemini analyzes payment behavior securely to flag high-risk subscribers and suggest retention strategies.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50">
                    <div class="w-12 h-12 rounded-lg bg-emerald-500/10 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Revenue Tracking</h3>
                    <p class="text-slate-400 leading-relaxed">Real-time MRR calculations, overdue payment flagging, and 6-month historical revenue trend visualizations.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 py-8 border-t border-slate-800 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} RecurTrack. Built for recurring revenue businesses.</p>
    </footer>

</body>
</html>