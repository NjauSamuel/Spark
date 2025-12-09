<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function sendContactWebhook(Contact $contact, string $event): void
    {
        $webhookUrl = config('services.webhook.url');

        if (!$webhookUrl) {
            Log::info('Webhook URL not configured, skipping webhook call', [
                'contact_id' => $contact->id,
                'event' => $event,
            ]);
            return;
        }

        try {
            $payload = [
                'event' => $event,
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'status' => $contact->status,
                    'created_at' => $contact->created_at?->toIso8601String(),
                    'updated_at' => $contact->updated_at?->toIso8601String(),
                ],
                'timestamp' => now()->toIso8601String(),
            ];

            $response = Http::timeout(5)->post($webhookUrl, $payload);

            Log::info('Webhook sent successfully', [
                'contact_id' => $contact->id,
                'event' => $event,
                'status' => $response->status(),
            ]);
        } catch (\Exception $e) {
            Log::error('Webhook failed', [
                'contact_id' => $contact->id,
                'event' => $event,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

