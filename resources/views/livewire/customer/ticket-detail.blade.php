<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('tickets.index') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            &larr; Back to Tickets
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $ticket->subject }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Created {{ $ticket->created_at->format('M d, Y h:i A') }}
                </p>
            </div>
            <div>
                @php
                    $color = match($ticket->status) {
                        'open' => 'bg-green-100 text-green-800',
                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                        'resolved' => 'bg-gray-100 text-gray-800',
                        default => 'bg-blue-100 text-blue-800',
                    };
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->category->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Priority</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($ticket->priority) }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $ticket->description }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($ticket->status === 'resolved' && !$ticket->rating)
        <livewire:ticket.rating :ticket="$ticket" />
    @elseif($ticket->rating)
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6 flex items-center justify-between">
            <div>
                <h4 class="text-sm font-medium text-gray-900">Your Rating</h4>
                <p class="text-sm text-gray-500 mt-1">{{ $ticket->rating->feedback ?? 'No feedback provided.' }}</p>
            </div>
            <div class="flex items-center space-x-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="h-5 w-5 {{ $i <= $ticket->rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
