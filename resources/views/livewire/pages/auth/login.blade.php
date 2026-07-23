<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectBasedOnRole();
    }

    public function loginAs(string $email): void
    {
        $user = \App\Models\User::where('email', $email)->first();
        if ($user) {
            \Illuminate\Support\Facades\Auth::login($user);
            Session::regenerate();
            $this->redirectBasedOnRole();
        }
    }

    protected function redirectBasedOnRole()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->hasRole('super_admin')) {
            $this->redirectIntended(default: route('super.dashboard'), navigate: true);
        } elseif ($user->hasRole('org_admin')) {
            $this->redirectIntended(default: route('admin.dashboard', ['tenant' => $user->organization->slug]), navigate: true);
        } elseif ($user->hasRole('agent')) {
            $this->redirectIntended(default: route('agent.dashboard', ['tenant' => $user->organization->slug]), navigate: true);
        } else {
            $this->redirectIntended(default: route('tickets.index', ['tenant' => $user->organization->slug]), navigate: true);
        }
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-line text-signal shadow-sm focus:ring-signal" name="remember">
                <span class="ms-2 text-sm text-slate">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate hover:text-ink rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-signal" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8 border-t pt-6">
        <h3 class="text-sm font-medium text-ink mb-4 text-center font-heading">Demo Logins</h3>
        <div class="flex flex-col space-y-2">
            <button wire:click="loginAs('customer@demo.com')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-line rounded-md font-semibold text-xs font-mono text-slate uppercase tracking-widest shadow-sm hover:bg-cloud focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Login as Demo Customer
            </button>
            <button wire:click="loginAs('agent@demo.com')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-50 border border-signal rounded-md font-semibold text-xs font-mono text-signal uppercase tracking-widest shadow-sm hover:bg-signal focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Login as Demo Agent
            </button>
            <button wire:click="loginAs('admin@demo.com')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-50 border border-purple-300 rounded-md font-semibold text-xs font-mono text-purple-700 uppercase tracking-widest shadow-sm hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mb-3">
                Login as Demo Admin
            </button>
            <button wire:click="loginAs('super@pulsedesk.local')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-50 border border-ember rounded-md font-semibold text-xs font-mono text-ember uppercase tracking-widest shadow-sm hover:bg-ember focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Login as Super Admin
            </button>
        </div>
    </div>
</div>
