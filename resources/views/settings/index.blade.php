<x-app-layout>
    <x-slot name="header">
        System Settings
    </x-slot>

    <div class="max-w-3xl mx-auto py-4 space-y-8">
        
        <!-- Business Profile Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-20 transition duration-500"></div>
            <div class="relative bg-slate-900 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-800">
                <div class="mb-6 flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-lg font-medium text-white">Business Profile</h3>
                        <p class="text-sm text-slate-400">Your core organization details.</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Edit Profile &rarr;</a>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Business Name</dt>
                        <dd class="mt-1 text-sm text-white">{{ Auth::user()->business->name ?? 'Not set' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Owner Name</dt>
                        <dd class="mt-1 text-sm text-white">{{ Auth::user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Account Email</dt>
                        <dd class="mt-1 text-sm text-white">{{ Auth::user()->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Member Since</dt>
                        <dd class="mt-1 text-sm text-white">{{ Auth::user()->created_at->format('F j, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- System Automations Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-medium text-slate-900">System Automations</h3>
                <p class="text-sm text-slate-500">Status of your background tasks and AI scheduler.</p>
            </div>

            <div class="space-y-6">
                <!-- Automation Row 1 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-emerald-100">
                            <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </span>
                    </div>
                    <div class="ml-3 text-sm">
                        <p class="font-medium text-slate-900">Automated Billing Generation</p>
                        <p class="text-slate-500 mt-1">Active. The system automatically creates pending billing cycles based on subscriber plans and flags overdue invoices.</p>
                    </div>
                </div>

                <!-- Automation Row 2 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-emerald-100">
                            <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </span>
                    </div>
                    <div class="ml-3 text-sm">
                        <p class="font-medium text-slate-900">AI Churn Prediction (Gemini)</p>
                        <p class="text-slate-500 mt-1">Active. Subscriber behavior is analyzed securely on a weekly schedule to predict churn risk.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>