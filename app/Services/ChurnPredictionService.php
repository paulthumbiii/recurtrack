<?php

namespace App\Services;

use App\Models\Subscriber;
use App\Models\ChurnInsight;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChurnPredictionService
{
    public function analyze(Subscriber $subscriber)
    {
        $billingData = $this->gatherBillingData($subscriber);
        
        try {
            // Try the Gemini API first
            $insightData = $this->callGeminiAPI($billingData);
        } catch (\Exception $e) {
            // If Gemini fails (Rate limit, 503, timeout), silently use the Local Fallback Engine!
            Log::warning("Gemini API failed for subscriber {$subscriber->id}. Using Local Fallback Engine.");
            $insightData = $this->generateFallbackInsight($billingData, $subscriber);
        }

        // Save the insight (whether from Gemini or Fallback)
        ChurnInsight::create([
            'subscriber_id' => $subscriber->id,
            'risk_level'    => $insightData['risk_level'],
            'narrative'     => $insightData['narrative'],
            'generated_at'  => now(),
        ]);
    }

    private function gatherBillingData(Subscriber $subscriber)
    {
        $cycles = $subscriber->billingCycles;
        
        return [
            'name' => $subscriber->name,
            'plan' => $subscriber->plan->name ?? 'Unknown',
            'tenure_days' => $subscriber->start_date->diffInDays(now()),
            'total_cycles' => $cycles->count(),
            'paid_cycles' => $cycles->where('status', 'paid')->count(),
            'overdue_cycles' => $cycles->where('status', 'overdue')->count(),
        ];
    }

    private function callGeminiAPI(array $data)
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            throw new \Exception("No Gemini API key found.");
        }

        $prompt = "Analyze this subscriber: Total Cycles: {$data['total_cycles']}, Paid: {$data['paid_cycles']}, Overdue: {$data['overdue_cycles']}, Tenure: {$data['tenure_days']} days. Output strictly valid JSON with two keys: 'risk_level' (must be exactly 'low', 'medium', or 'high') and 'narrative' (a 2-sentence explanation of the risk and a retention suggestion). No markdown formatting.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        if (!$response->successful()) {
            throw new \Exception("API Error: " . $response->status());
        }

        $result = $response->json();
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Clean up markdown block if Gemini adds it
        $text = str_replace(['```json', '```'], '', $text);
        $json = json_decode(trim($text), true);

        if (!$json || !isset($json['risk_level']) || !isset($json['narrative'])) {
            throw new \Exception("Invalid JSON structure from Gemini");
        }

        return $json;
    }

    /**
     * THE LOCAL FALLBACK ENGINE
     * Generates a realistic response based on actual data if the API fails.
     */
    private function generateFallbackInsight(array $data, Subscriber $subscriber)
    {
        if ($data['total_cycles'] == 0) {
            return [
                'risk_level' => 'low',
                'narrative' => "{$data['name']} is a brand new subscriber. Welcome them to the {$data['plan']} plan and ensure their onboarding experience is smooth to build early loyalty."
            ];
        }

        if ($data['overdue_cycles'] > 0) {
            return [
                'risk_level' => 'high',
                'narrative' => "{$data['name']} currently has {$data['overdue_cycles']} overdue payment(s). This is a strong indicator of churn. Reach out immediately to resolve the payment issue or offer a flexible payment arrangement."
            ];
        }

        $paidRatio = $data['paid_cycles'] / $data['total_cycles'];

        if ($paidRatio < 0.5) {
            return [
                'risk_level' => 'medium',
                'narrative' => "Although there are no current overdue balances, {$data['name']} has missed or delayed payments in the past. Consider checking in to ensure they are getting value from the {$data['plan']} plan."
            ];
        }

        return [
            'risk_level' => 'low',
            'narrative' => "{$data['name']} shows excellent payment reliability with {$data['paid_cycles']} successful cycle(s) over {$data['tenure_days']} days. They are highly engaged; consider offering them an annual upgrade or loyalty perk."
        ];
    }
}