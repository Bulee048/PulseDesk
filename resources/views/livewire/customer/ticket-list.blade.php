<div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
    
    @if(session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms class="mb-8 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm flex justify-between items-center" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="block sm:inline font-medium">{{ session('status') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800 focus:outline-none">
                <svg class="fill-current h-5 w-5" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-ink sm:text-4xl font-heading">Support Tickets</h2>
            <p class="mt-2 text-sm text-slate">Track and manage your requests with our support team.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <div class="relative group w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate/70 group-focus-within:text-signal transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" class="pl-10 w-full rounded-xl border-line shadow-sm focus:border-signal focus:ring focus:ring-signal focus:ring-opacity-50 transition-all duration-200 bg-white" placeholder="Search your tickets...">
            </div>
            
            <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal transform transition-transform duration-200 hover:scale-105">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Ticket
            </a>
        </div>
    </div>

    <div wire:loading class="w-full">
        <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-2">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-2xl shadow-sm border border-line p-6 animate-pulse">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-slate/10"></div>
                            <div class="h-6 w-20 rounded-full bg-slate/10"></div>
                        </div>
                        <div class="h-6 w-16 rounded-lg bg-slate/10"></div>
                    </div>
                    
                    <div class="h-6 w-3/4 rounded bg-slate/20 mb-2"></div>
                    
                    <div class="mt-4 flex flex-wrap items-center gap-4">
                        <div class="h-8 w-24 rounded-lg bg-slate/10"></div>
                        <div class="h-8 w-32 rounded-lg bg-slate/10"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div wire:loading.remove>
        @if($tickets->count() > 0)
            <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-2">
                @foreach($tickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block group">
                        <div class="bg-white rounded-2xl shadow-sm border border-line p-6 hover:shadow-lg hover:border-signal transition-all duration-300 transform group-hover:-translate-y-1 relative overflow-hidden">
                            <!-- Subtle gradient decoration -->
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 opacity-50 transition-transform duration-500 group-hover:scale-150"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-indigo-50 text-signal font-semibold text-sm">
                                            #{{ $ticket->id }}
                                        </span>
                                        @php
                                            $color = match($ticket->status) {
                                                'open' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                'in_progress' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'resolved' => 'bg-slate-100 text-slate-700 border-slate-200',
                                                default => 'bg-signal text-signal border-signal',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs font-mono leading-5 font-bold rounded-full border {{ $color }} uppercase tracking-wider">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </div>
                                    <span class="text-xs font-mono font-medium text-slate bg-cloud px-2.5 py-1 rounded-lg">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-bold text-ink group-hover:text-signal transition-colors duration-200 mb-2 truncate font-heading">
                                    {{ $ticket->subject }}
                                </h3>
                                
                                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-slate">
                                    <div class="flex items-center bg-cloud px-3 py-1.5 rounded-lg">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-slate/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $ticket->category->name }}
                                    </div>
                                    <div class="flex items-center bg-cloud px-3 py-1.5 rounded-lg">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-slate/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @php
                                            $priorityColor = match($ticket->priority) {
                                                'high' => 'text-rose-600 font-semibold',
                                                'medium' => 'text-amber-600 font-semibold',
                                                default => 'text-emerald-600 font-semibold',
                                            };
                                        @endphp
                                        <span class="{{ $priorityColor }}">{{ ucfirst($ticket->priority) }} Priority</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center bg-white shadow-sm border border-line rounded-3xl p-16">
                <div class="mx-auto h-24 w-24 bg-indigo-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-12 w-12 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="mt-2 text-xl font-bold text-ink font-heading">No tickets found</h3>
                <p class="mt-2 text-base text-slate max-w-sm mx-auto">You haven't created any support tickets yet, or none match your search criteria.</p>
                <div class="mt-8">
                    <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-xl text-white bg-signal hover:bg-signal focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create Your First Ticket
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

