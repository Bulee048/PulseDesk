<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-ink sm:text-4xl font-heading">
            Knowledge Base
        </h1>
        <p class="mt-3 max-w-2xl mx-auto text-xl text-slate sm:mt-4">
            Find answers, guides, and tutorials.
        </p>
        <div class="mt-6 max-w-xl mx-auto">
            <input type="text" wire:model.live="search" placeholder="Search for articles..." class="shadow-sm focus:ring-signal focus:border-signal block w-full sm:text-lg border-line rounded-md py-3 px-4">
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2" wire:loading.remove>
        @forelse($articles as $article)
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
                <a href="/kb/{{ $article->slug }}" class="block px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-signal mb-2 font-heading">
                        {{ $article->title }}
                    </h3>
                    <p class="text-sm text-slate mb-4 line-clamp-2">
                        {{ Str::limit(strip_tags($article->body), 120) }}
                    </p>
                    <div class="flex items-center text-xs font-mono text-slate/70">
                        @if($article->category)
                            <span class="bg-cloud text-slate px-2 py-1 rounded-full mr-3">{{ $article->category->name }}</span>
                        @endif
                        <span>{{ $article->view_count }} views</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-2 text-center py-16 bg-cloud/50 rounded-lg border border-line">
                <svg class="w-12 h-12 text-slate/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-slate font-medium">No articles found matching your search.</p>
                <p class="text-sm text-slate/70 mt-1">Try tweaking your keywords or browse all categories.</p>
            </div>
        @endforelse
    </div>
    
    <div wire:loading class="w-full">
        <div class="grid gap-6 lg:grid-cols-2">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white overflow-hidden shadow rounded-lg p-6 animate-pulse">
                    <div class="h-6 bg-slate/20 rounded w-3/4 mb-4"></div>
                    <div class="h-4 bg-slate/10 rounded w-full mb-2"></div>
                    <div class="h-4 bg-slate/10 rounded w-5/6 mb-6"></div>
                    <div class="flex items-center gap-3">
                        <div class="h-6 bg-slate/20 rounded-full w-20"></div>
                        <div class="h-4 bg-slate/10 rounded w-16"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    
    <div class="mt-8">
        {{ $articles->links() }}
    </div>
</div>
