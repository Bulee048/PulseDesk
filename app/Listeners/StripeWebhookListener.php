<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use App\Models\Organization;
use App\Models\Plan;

class StripeWebhookListener
{
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $session = $event->payload['data']['object'];
            
            // Assuming we pass client_reference_id as the organization ID during checkout
            $orgId = $session['client_reference_id'] ?? null;
            
            if ($orgId) {
                $org = Organization::find($orgId);
                
                // We need to look up the plan based on the price ID in the session
                // The checkout session doesn't directly expose the price ID at the top level, 
                // but we can query it or simply pass the plan_id in the checkout session metadata.
                $planId = $session['metadata']['plan_id'] ?? null;
                
                if ($org && $planId) {
                    $org->update(['plan_id' => $planId]);
                }
            }
        }
    }
}
