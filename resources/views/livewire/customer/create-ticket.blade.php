
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-ink font-heading">Create New Ticket</h3>
            <p class="mt-1 max-w-2xl text-sm text-slate">Please provide detailed information to help us assist you.</p>
        </div>
        <div class="border-t border-line p-6">
            <form wire:submit="save" class="space-y-6">
                @if ($errors->any())
                    <div class="rounded-md bg-ember/10 p-4 border border-ember/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-ember" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-ember">There were errors with your submission</h3>
                            </div>
                        </div>
                    </div>
                @endif
                <div>
                    <label for="subject" class="block text-sm font-medium text-slate">Subject</label>
                    <input type="text" wire:model="subject" id="subject" class="mt-1 block w-full @error('subject') border-ember text-ember focus:border-ember focus:ring-ember @else border-line focus:border-signal focus:ring-signal @enderror rounded-md shadow-sm sm:text-sm transition-colors duration-200">
                    @error('subject') <span class="text-ember text-xs font-mono mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate">Category</label>
                    <select wire:model="category_id" id="category_id" class="mt-1 block w-full @error('category_id') border-ember text-ember focus:border-ember focus:ring-ember @else border-line focus:border-signal focus:ring-signal @enderror rounded-md shadow-sm sm:text-sm transition-colors duration-200">
                        <option value="">Select a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-ember text-xs font-mono mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-slate">Priority</label>
                    <select wire:model="priority" id="priority" class="mt-1 block w-full @error('priority') border-ember text-ember focus:border-ember focus:ring-ember @else border-line focus:border-signal focus:ring-signal @enderror rounded-md shadow-sm sm:text-sm transition-colors duration-200">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    @error('priority') <span class="text-ember text-xs font-mono mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate">Description</label>
                    <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full @error('description') border-ember text-ember focus:border-ember focus:ring-ember @else border-line focus:border-signal focus:ring-signal @enderror rounded-md shadow-sm sm:text-sm transition-colors duration-200"></textarea>
                    @error('description') <span class="text-ember text-xs font-mono mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="attachment" class="block text-sm font-medium text-slate">Attachment (optional)</label>
                    <input type="file" wire:model="attachment" id="attachment" class="mt-1 block w-full text-sm text-slate file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-signal hover:file:bg-signal">
                    <div wire:loading wire:target="attachment" class="text-sm text-slate mt-1">Uploading...</div>
                    @error('attachment') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-signal hover:bg-signal focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Submit Ticket</span>
                        <span wire:loading wire:target="save">Submitting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
