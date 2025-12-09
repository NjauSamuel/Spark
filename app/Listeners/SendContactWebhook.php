<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Services\WebhookService;

class SendContactWebhook
{
    public function __construct(
        private WebhookService $webhookService
    ) {
    }

    public function handle(ContactCreated|ContactUpdated $event): void
    {
        $eventType = $event instanceof ContactCreated ? 'contact.created' : 'contact.updated';
        $this->webhookService->sendContactWebhook($event->contact, $eventType);
    }
}
