<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Organization;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Signup extends Component
{
    public $company_name = '';
    public $slug = '';
    public $email = '';
    public $password = '';
    public $slug_taken = false;

    public function updatedCompanyName()
    {
        $this->slug = Str::slug($this->company_name);
        $this->checkSlug();
    }

    public function updatedSlug()
    {
        $this->slug = Str::slug($this->slug);
        $this->checkSlug();
    }

    public function checkSlug()
    {
        $this->slug_taken = Organization::where('slug', $this->slug)->exists();
    }

    public function signup()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:organizations,slug',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $freePlan = Plan::where('name', 'Free')->first();

        $org = Organization::create([
            'name' => $this->company_name,
            'slug' => $this->slug,
            'status' => 'active',
            'plan_id' => $freePlan->id,
            'trial_ends_at' => now()->addDays(14),
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'organization_id' => $org->id,
            'role' => 'org_admin',
        ]);

        $user->assignRole('org_admin');

        Auth::login($user);

        return redirect()->to('http://' . $this->slug . '.' . preg_replace('#^https?://#', '', env('APP_URL', 'pulsedesk.test')) . '/onboarding');
    }

    public function render()
    {
        return view('livewire.public.signup')->layout('layouts.guest');
    }
}
