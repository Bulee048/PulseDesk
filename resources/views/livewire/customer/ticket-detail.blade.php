<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('tickets.index', ['tenant' => $ticket->organization->slug]) }}" wire:navigate class="text-sm font-medium text-signal hover:text-signal">
            &larr; Back to Tickets
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-ink font-heading">
                    {{ $ticket->subject }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-slate">
                    Created {{ $ticket->created_at->format('M d, Y h:i A') }}
                </p>
            </div>
            <div>
                @php
                    $color = match($ticket->status) {
                        'open' => 'bg-green-100 text-green-800',
                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                        'resolved' => 'bg-cloud text-slate',
                        default => 'bg-signal text-signal',
                    };
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
        </div>
        <div class="border-t border-line px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate">Category</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $ticket->category->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate">Priority</dt>
                    <dd class="mt-1 text-sm text-ink">{{ ucfirst($ticket->priority) }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-slate">Description</dt>
                    <dd class="mt-1 text-sm text-ink whitespace-pre-wrap">{{ $ticket->description }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($ticket->status === 'resolved' && !$ticket->rating)
        <livewire:ticket.rating :ticket="$ticket" />
    @elseif($ticket->rating)
        <div class="bg-cloud border border-line rounded-lg p-4 mb-6 flex items-center justify-between">
            <div>
                <h4 class="text-sm font-medium text-ink font-heading">Your Rating</h4>
                <p class="text-sm text-slate mt-1">{{ $ticket->rating->feedback ?? 'No feedback provided.' }}</p>
            </div>
            <div class="flex items-center space-x-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="h-5 w-5 {{ $i <= $ticket->rating->rating ? 'text-yellow-400' : 'text-slate/70' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
        </div>
    @endif

    <div class="bg-white shadow sm:rounded-lg mt-6">
        <livewire:ticket.chat :ticket="$ticket" />
    </div>
</div>
