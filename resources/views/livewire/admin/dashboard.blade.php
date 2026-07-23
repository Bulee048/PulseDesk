<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-ink sm:text-3xl sm:truncate font-heading">Platform Dashboard</h2>
    </div>

    <!-- Live Metrics -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-slate truncate">Signups Today</dt>
                <dd class="mt-1 text-3xl font-semibold text-ink">{{ $signupsToday }}</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-slate truncate">Total Open Tickets</dt>
                <dd class="mt-1 text-3xl font-semibold text-ink">{{ $totalOpenTickets }}</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-slate truncate">Estimated MRR</dt>
                <dd class="mt-1 text-3xl font-semibold text-ink">${{ number_format($mrr, 2) }}</dd>
            </div>
        </div>
    </div>

    <!-- Organizations Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-ink font-heading">Organizations</h3>
            <div class="w-1/3">
                <input type="text" wire:model.live="search" placeholder="Search organizations..." class="shadow-sm focus:ring-signal focus:border-signal block w-full sm:text-sm border-line rounded-md">
            </div>
        </div>
        
        <div class="border-t border-line">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cloud">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Agents</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Tickets</th>
                        <th class="px-6 py-3 text-right text-xs font-mono font-medium text-slate uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($organizations as $org)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-ink">{{ $org->name }}</div>
                                <div class="text-sm text-slate">{{ $org->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs font-mono leading-5 font-semibold rounded-full {{ $org->status === 'active' ? 'bg-signal/10 text-signal' : 'bg-ember/10 text-ember' }}">
                                    {{ ucfirst($org->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate">
                                {{ $org->plan->name ?? 'None' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate">
                                {{ $org->agent_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate">
                                {{ $org->tickets_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="impersonate({{ $org->id }})" class="text-signal hover:text-signal mr-3">Impersonate</button>
                                
                                @if($org->status === 'active')
                                    <button wire:click="suspend({{ $org->id }})" onclick="confirm('Are you sure you want to suspend this organization?') || event.stopImmediatePropagation()" class="text-ember hover:text-ember/80">Suspend</button>
                                @else
                                    <button wire:click="reactivate({{ $org->id }})" onclick="confirm('Are you sure you want to reactivate this organization?') || event.stopImmediatePropagation()" class="text-signal hover:text-signal/80">Reactivate</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-line sm:px-6">
            {{ $organizations->links() }}
        </div>
    </div>
</div>
