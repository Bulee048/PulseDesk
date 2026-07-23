<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\User;
use App\Models\Ticket;
use Carbon\Carbon;

class Billing extends Component
{
    public function render()
    {
        $org = app(Organization::class);
        $plan = Plan::find($org->plan_id);

        $agentCount = User::where('organization_id', $org->id)
            ->whereHas('roles', function($q) {
                $q->whereIn('name', ['agent', 'org_admin']);
            })->count();

        $ticketCount = Ticket::where('organization_id', $org->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $plans = Plan::all();

        return view('livewire.tenant.billing', [
            'org' => $org,
            'currentPlan' => $plan,
            'agentCount' => $agentCount,
            'ticketCount' => $ticketCount,
            'plans' => $plans,
        ])->layout('layouts.app');
    }

    public function checkout($planId)
    {
        $org = app(Organization::class);
        $planToBuy = Plan::find($planId);
        
        if (!$planToBuy || !$planToBuy->stripe_price_id) {
            return;
        }

        return $org->checkout($planToBuy->stripe_price_id, [
            'success_url' => route('billing') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('billing'),
            'client_reference_id' => $org->id,
            'metadata' => [
                'plan_id' => $planToBuy->id,
            ],
        ]);
    }
}
