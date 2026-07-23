<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold leading-7 text-ink sm:text-3xl sm:truncate font-heading">Knowledge Base Articles</h2>
        @if(!$isEditing)
            <button wire:click="create" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-signal hover:bg-signal">
                New Article
            </button>
        @endif
    </div>

    @if($isEditing)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate">Title</label>
                    <input type="text" wire:model="title" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm">
                    @error('title') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate">Category (Optional)</label>
                    <select wire:model="category_id" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate">Body</label>
                    <textarea wire:model="body" rows="6" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm"></textarea>
                    @error('body') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" wire:model="published" class="h-4 w-4 text-signal focus:ring-signal border-line rounded">
                    <label class="ml-2 block text-sm text-ink">Published</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="cancel" class="inline-flex justify-center py-2 px-4 border border-line shadow-sm text-sm font-medium rounded-md text-slate bg-white hover:bg-cloud focus:outline-none">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-signal hover:bg-signal focus:outline-none">
                        Save Article
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cloud">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-mono font-medium text-slate uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-right text-xs font-mono font-medium text-slate uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($articles as $article)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">
                                {{ $article->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate">
                                {{ $article->category->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs font-mono leading-5 font-semibold rounded-full {{ $article->published ? 'bg-signal/10 text-signal' : 'bg-slate/10 text-slate' }}">
                                    {{ $article->published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate">
                                {{ $article->view_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $article->id }})" class="text-signal hover:text-signal mr-3 focus:outline-none focus:ring-2 focus:ring-signal rounded-sm">Edit</button>
                                <button wire:click="delete({{ $article->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="text-ember hover:text-ember focus:outline-none focus:ring-2 focus:ring-ember rounded-sm">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-ink">No articles</h3>
                                <p class="mt-1 text-sm text-slate">Get started by creating a new help article.</p>
                                <div class="mt-6">
                                    <button wire:click="create" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-signal hover:bg-signal focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        New Article
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
