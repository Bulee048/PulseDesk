<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        @if($step === 1)
            <h2 class="text-xl font-bold mb-4 font-heading">Step 1: Invite an Agent</h2>
            <p class="mb-4 text-slate">Invite a team member to help you resolve tickets, or skip this step for now.</p>
            
            <form wire:submit="inviteAgent" class="space-y-4">
                @error('agent_limit')
                    <div class="bg-red-50 p-4 rounded-md">
                        <p class="text-sm text-ember">{{ $message }} <a href="{{ route('billing') }}" class="font-bold underline">Upgrade Plan</a></p>
                    </div>
                @enderror

                <div>
                    <label class="block text-sm font-medium text-slate">Agent Name</label>
                    <input type="text" wire:model="agent_name" class="mt-1 block w-full border-line rounded-md">
                    @error('agent_name') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate">Agent Email</label>
                    <input type="email" wire:model="agent_email" class="mt-1 block w-full border-line rounded-md">
                    @error('agent_email') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-between items-center pt-4">
                    <button type="button" wire:click="skipAgent" class="text-signal hover:text-signal">Skip this step</button>
                    <button type="submit" class="bg-signal text-white px-4 py-2 rounded-md hover:bg-signal">Send Invite</button>
                </div>
            </form>
        @else
            <h2 class="text-xl font-bold mb-4 font-heading">Step 2: Create a Category</h2>
            <p class="mb-4 text-slate">Create your first ticket category to help organize customer requests.</p>

            <form wire:submit="finish" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate">Category Name</label>
                    <input type="text" wire:model="category_name" class="mt-1 block w-full border-line rounded-md" placeholder="e.g. Technical Support">
                    @error('category_name') <span class="text-ember text-xs font-mono">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-signal text-white px-4 py-2 rounded-md hover:bg-signal">Finish Onboarding</button>
                </div>
            </form>
        @endif
    </div>
</div>
