<x-app-layout>
    <x-slot name="header">
        AI Churn Insights
    </x-slot>

    <!-- Header / Magic Vibe -->
    <div class="flex justify-between items-end mb-6">
        <div>
            <p class="text-sm text-slate-500 max-w-2xl">
                Powered by Google Gemini. This AI evaluates billing history, tenure, and payment reliability to predict churn risk and suggest retention strategies.
            </p>
        </div>
        <div class="hidden md:block">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-sm">
                <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
                AI Enabled
            </span>
        </div>
    </div>

    @if($latestInsights->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                <svg class="w-8 h-8 text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900">No Insights Generated Yet</h3>
            <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">Insights are created automatically by the system scheduler once your subscribers have billing history to analyze.</p>
        </div>
    @else
        <!-- Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <x-metric-card label="High Risk Accounts" value="{{ $highRisk->count() }}" trend="{{ $highRisk->count() > 0 ? 'Requires immediate action' : 'All clear' }}" :trendUp="$highRisk->count() == 0" />
            <x-metric-card label="Medium Risk Accounts" value="{{ $mediumRisk->count() }}" trend="Keep an eye on these" :trendUp="$mediumRisk->count() == 0" />
            <x-metric-card label="Low Risk Accounts" value="{{ $lowRisk->count() }}" trend="Healthy subscribers" :trendUp="true" />
        </div>

        <!-- Alpine.js Tabs for Risk Levels -->
        <div x-data="{ tab: 'high' }">
            <!-- Tab Navigation -->
            <div class="border-b border-slate-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="tab = 'high'" 
                            :class="tab === 'high' ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors relative">
                        High Risk
                        <span class="ml-2 bg-rose-100 text-rose-600 py-0.5 px-2.5 rounded-full text-xs">{{ $highRisk->count() }}</span>
                    </button>
                    
                    <button @click="tab = 'medium'" 
                            :class="tab === 'medium' ? 'border-amber-500 text-amber-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Medium Risk
                        <span class="ml-2 bg-amber-100 text-amber-600 py-0.5 px-2.5 rounded-full text-xs">{{ $mediumRisk->count() }}</span>
                    </button>
                    
                    <button @click="tab = 'low'" 
                            :class="tab === 'low' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Low Risk
                        <span class="ml-2 bg-emerald-100 text-emerald-600 py-0.5 px-2.5 rounded-full text-xs">{{ $lowRisk->count() }}</span>
                    </button>
                </nav>
            </div>

            <!-- Tab Contents -->
            
            <!-- High Risk Content -->
            <div x-show="tab === 'high'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4" style="display: none;">
                @forelse($highRisk as $insight)
                    <x-risk-card :insight="$insight" />
                @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-slate-200 border-dashed">
                        <p class="text-slate-500 text-sm">Great news! No high-risk subscribers right now.</p>
                    </div>
                @endforelse
            </div>

            <!-- Medium Risk Content -->
            <div x-show="tab === 'medium'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4" style="display: none;">
                @forelse($mediumRisk as $insight)
                    <x-risk-card :insight="$insight" />
                @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-slate-200 border-dashed">
                        <p class="text-slate-500 text-sm">No medium-risk subscribers at the moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- Low Risk Content -->
            <div x-show="tab === 'low'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4" style="display: none;">
                @forelse($lowRisk as $insight)
                    <x-risk-card :insight="$insight" />
                @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-slate-200 border-dashed">
                        <p class="text-slate-500 text-sm">No low-risk subscribers analyzed yet.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    @endif
</x-app-layout>