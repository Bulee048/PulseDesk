<div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
    <div class="bg-white/60 backdrop-blur-xl border border-white/40 shadow-sm rounded-3xl p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Agent Workspace</h2>
            <p class="mt-1 text-sm text-gray-500">Manage and resolve customer support tickets efficiently.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <div class="relative w-full sm:w-48">
                <select wire:model.live="filter" class="appearance-none block w-full bg-white/80 border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-xl leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors shadow-sm text-sm font-medium cursor-pointer">
                    <option value="all">All Tickets</option>
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>

            <div class="relative group w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" class="pl-10 block w-full sm:text-sm border-gray-200 rounded-xl bg-white/80 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm py-2.5" placeholder="Search any ticket...">
            </div>
        </div>
    </div>

    <div wire:loading class="w-full flex justify-center py-20">
        <div class="relative">
            <div class="w-12 h-12 rounded-full absolute border-4 border-solid border-gray-200"></div>
            <div class="w-12 h-12 rounded-full animate-spin absolute border-4 border-solid border-indigo-500 border-t-transparent shadow-md"></div>
        </div>
    </div>

    <div wire:loading.remove>
        @if($tickets->count() > 0)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($tickets as $ticket)
                        <li class="group hover:bg-slate-50 transition-colors duration-200">
                            <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block p-5 sm:px-8">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">
                                            <span class="text-gray-400 font-normal mr-1">#{{ $ticket->id }}</span>
                                            {{ $ticket->subject }}
                                        </p>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        @php
                                            $color = match($ticket->status) {
                                                'open' => 'bg-emerald-100 text-emerald-700 shadow-sm shadow-emerald-200',
                                                'in_progress' => 'bg-amber-100 text-amber-700 shadow-sm shadow-amber-200',
                                                'resolved' => 'bg-slate-100 text-slate-700 shadow-sm shadow-slate-200',
                                                default => 'bg-blue-100 text-blue-700 shadow-sm shadow-blue-200',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $color }} uppercase tracking-wider transform transition-transform group-hover:scale-105">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm">
                                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-gray-500">
                                        <div class="flex items-center bg-gray-100/50 px-2.5 py-1 rounded-md text-gray-700 font-medium">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $ticket->customer->name ?? 'Unknown Customer' }}
                                        </div>
                                        <div class="flex items-center text-gray-500">
                                            <span class="w-2 h-2 rounded-full bg-gray-300 mr-2"></span>
                                            {{ $ticket->category->name ?? 'N/A' }}
                                        </div>
                                        <div class="flex items-center">
                                            @php
                                                $priorityColor = match($ticket->priority) {
                                                    'high' => 'bg-rose-500',
                                                    'medium' => 'bg-amber-500',
                                                    default => 'bg-emerald-500',
                                                };
                                            @endphp
                                            <span class="w-2 h-2 rounded-full {{ $priorityColor }} mr-2 animate-pulse"></span>
                                            <span class="capitalize">{{ $ticket->priority }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 sm:mt-0 flex items-center text-gray-400 font-medium text-xs bg-gray-50 px-2 py-1 rounded">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center bg-white shadow-sm border border-gray-100 rounded-3xl p-16">
                <div class="mx-auto h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="mt-2 text-xl font-bold text-gray-900">All caught up!</h3>
                <p class="mt-2 text-base text-gray-500">There are no tickets matching your current filter.</p>
            </div>
        @endif
    </div>
</div>
