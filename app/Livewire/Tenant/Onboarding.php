<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\Category;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Onboarding extends Component
{
    public $step = 1;

    // Step 1: Agent
    public $agent_name = '';
    public $agent_email = '';

    // Step 2: Category
    public $category_name = '';

    public function skipAgent()
    {
        $this->step = 2;
    }

    public function inviteAgent()
    {
        $this->validate([
            'agent_name' => 'required|string|max:255',
            'agent_email' => 'required|email|unique:users,email',
        ]);

        $org = app(\App\Models\Organization::class);
        $plan = Plan::find($org->plan_id);

        // Limit Enforcement
        if ($plan && $plan->agent_limit !== null) {
            $agentCount = User::where('organization_id', $org->id)
                ->whereHas('roles', function($q) {
                    $q->whereIn('name', ['agent', 'org_admin']);
                })->count();

            if ($agentCount >= $plan->agent_limit) {
                $this->addError('agent_limit', 'You have reached your agent limit for the current plan.');
                return;
            }
        }

        $user = User::create([
            'name' => $this->agent_name,
            'email' => $this->agent_email,
            'password' => Hash::make(Str::random(12)),
            'role' => 'agent',
        ]);
        $user->assignRole('agent');

        $this->step = 2;
    }

    public function finish()
    {
        $this->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $this->category_name,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.tenant.onboarding')->layout('layouts.app');
    }
}
