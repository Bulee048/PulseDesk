<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-ink sm:text-3xl sm:truncate font-heading">Billing & Usage</h2>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-ink font-heading">Current Plan: {{ $currentPlan->name }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-slate">
                    @if($org->trial_ends_at && $org->trial_ends_at->isFuture())
                        Trial ends in {{ $org->trial_ends_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
        <div class="border-t border-line px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate">Agents Used</dt>
                    <dd class="mt-1 text-sm text-ink sm:mt-0 sm:col-span-2">
                        <div class="flex items-center">
                            <div class="flex-1 bg-slate/10 rounded-full h-2.5 mr-4">
                                @php
                                    $agentPercent = $currentPlan->agent_limit ? min(100, ($agentCount / $currentPlan->agent_limit) * 100) : 0;
                                @endphp
                                <div class="bg-signal h-2.5 rounded-full" style="width: {{ $agentPercent }}%"></div>
                            </div>
                            <span class="w-20 text-right">{{ $agentCount }} / {{ $currentPlan->agent_limit ?? '∞' }}</span>
                        </div>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate">Tickets This Month</dt>
                    <dd class="mt-1 text-sm text-ink sm:mt-0 sm:col-span-2">
                        <div class="flex items-center">
                            <div class="flex-1 bg-slate/10 rounded-full h-2.5 mr-4">
                                @php
                                    $ticketPercent = $currentPlan->ticket_limit_per_month ? min(100, ($ticketCount / $currentPlan->ticket_limit_per_month) * 100) : 0;
                                @endphp
                                <div class="bg-signal h-2.5 rounded-full" style="width: {{ $ticketPercent }}%"></div>
                            </div>
                            <span class="w-20 text-right">{{ $ticketCount }} / {{ $currentPlan->ticket_limit_per_month ?? '∞' }}</span>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <h3 class="text-xl font-bold mb-4 font-heading">Available Plans</h3>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @foreach($plans as $plan)
            <div class="bg-white shadow rounded-lg p-6 border {{ $currentPlan->id === $plan->id ? 'border-signal ring-2 ring-signal' : 'border-line' }}">
                <h4 class="text-lg font-bold font-heading">{{ $plan->name }}</h4>
                <p class="text-2xl font-bold mt-2">${{ number_format($plan->price_cents / 100, 2) }}<span class="text-sm text-slate font-normal">/mo</span></p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li>{{ $plan->agent_limit ?? 'Unlimited' }} Agents</li>
                    <li>{{ $plan->ticket_limit_per_month ?? 'Unlimited' }} Tickets/mo</li>
                </ul>
                <div class="mt-6">
                    @if($currentPlan->id === $plan->id)
                        <button disabled class="w-full bg-cloud text-slate py-2 px-4 rounded-md font-medium cursor-not-allowed">Current Plan</button>
                    @else
                        <button wire:click="checkout({{ $plan->id }})" class="w-full bg-signal text-white py-2 px-4 rounded-md font-medium hover:bg-signal">Upgrade</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
