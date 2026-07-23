<div>
    {{-- The Master doesn't talk, he acts. --}}
</div>

<div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
    <h4 class="text-lg font-medium text-gray-900 mb-2">Rate Your Support Experience</h4>
    <p class="text-sm text-gray-500 mb-4">Your ticket has been marked as resolved. Please let us know how we did.</p>
    
    <form wire:submit="submitRating">
        <div class="flex items-center space-x-2 mb-4">
            @for($i = 1; $i <= 5; $i++)
                <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none">
                    <svg class="h-8 w-8 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            @endfor
            @error('rating') <span class="text-red-500 text-xs ml-2">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="feedback" class="sr-only">Feedback</label>
            <textarea wire:model="feedback" id="feedback" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Any additional feedback? (Optional)"></textarea>
            @error('feedback') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Rating
            </button>
        </div>
    </form>
</div>
