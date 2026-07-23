<div>
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-ink text-center font-heading">Create your workspace</h2>
        <p class="text-slate text-center mt-2">Start your 14-day free trial today.</p>
    </div>

    <form wire:submit="signup" class="space-y-6">
        <div>
            <label for="company_name" class="block text-sm font-medium text-slate">Company Name</label>
            <input type="text" wire:model.live="company_name" id="company_name" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm" placeholder="Acme Corp">
            @error('company_name') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-slate">Workspace URL</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" wire:model.live="slug" id="slug" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md focus:ring-signal focus:border-signal sm:text-sm border-line" placeholder="acme-corp">
                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-line bg-cloud text-slate sm:text-sm">
                    .pulsedesk.test
                </span>
            </div>
            @if($slug_taken)
                <span class="text-ember text-xs font-mono">This URL is already taken.</span>
            @endif
            @error('slug') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate">Work Email</label>
            <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm">
            @error('email') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate">Password</label>
            <input type="password" wire:model="password" id="password" class="mt-1 block w-full border-line rounded-md shadow-sm focus:ring-signal focus:border-signal sm:text-sm">
            @error('password') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-signal hover:bg-signal focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal" {{ $slug_taken ? 'disabled' : '' }}>
                Create Workspace
            </button>
        </div>
    </form>
</div>
