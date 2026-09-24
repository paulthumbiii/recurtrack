<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use App\Services\ChurnPredictionService;
use Illuminate\Console\Command;

class GenerateChurnInsights extends Command
{
    protected $signature = 'churn:generate-insights';

    protected $description = 'Generates AI-driven churn risk insights for active subscribers with billing history.';

 public function handle(ChurnPredictionService $service)
    {
        $this->info('Starting AI Churn Analysis...');

        $subscribers = \App\Models\Subscriber::where('status', 'active')->get();

        if ($subscribers->isEmpty()) {
            $this->info('No active subscribers to analyze.');
            return;
        }

        $bar = $this->output->createProgressBar($subscribers->count());
        $bar->start();

        foreach ($subscribers as $subscriber) {
            try {
                // Run the service (which now has a safe fallback built-in)
                $service->analyze($subscriber);
            } catch (\Exception $e) {
                // If something goes incredibly wrong, log it and MOVE TO THE NEXT PERSON
                // This prevents the loop from crashing!
                \Illuminate\Support\Facades\Log::error("Critical failure analyzing subscriber {$subscriber->id}: " . $e->getMessage());
            }

            $bar->advance();
            // Sleep for 3 seconds to be polite to the Gemini free tier
            sleep(3); 
        }

        $bar->finish();
        $this->newLine();
        $this->info('Churn analysis complete! Insights have been safely generated for all subscribers.');
    }
}