<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-4">
        <a href="/kb" class="text-signal hover:text-signal flex items-center text-sm font-medium">
            &larr; Back to Knowledge Base
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-line">
            <h1 class="text-3xl leading-9 font-extrabold text-ink font-heading">
                {{ $article->title }}
            </h1>
            <div class="mt-2 max-w-2xl text-sm text-slate flex items-center">
                @if($article->category)
                    <span class="bg-cloud text-slate px-2 py-1 rounded-full mr-3">{{ $article->category->name }}</span>
                @endif
                <span>{{ $article->view_count }} views</span>
            </div>
        </div>
        <div class="px-4 py-8 sm:px-6 prose max-w-none text-slate">
            {!! nl2br(e($article->body)) !!}
        </div>
    </div>

    <div class="bg-cloud border border-signal rounded-lg p-6 text-center">
        <h3 class="text-lg font-medium text-signal mb-2 font-heading">Still stuck? We're here to help!</h3>
        <p class="text-signal mb-4">Our support team is ready to assist you with any remaining questions.</p>
        
        <a href="{{ route('tickets.create', ['category' => $article->category_id]) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-signal hover:bg-signal">
            Open a Ticket
        </a>
    </div>
</div>
