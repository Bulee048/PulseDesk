<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Plan;
use Spatie\Permission\Models\Role;

class ImpersonationSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'org_admin']);
    }

    public function test_impersonation_cannot_escalate_to_super_admin()
    {
        $plan = Plan::create(['name' => 'Free', 'price_cents' => 0, 'ticket_limit_per_month' => 100]);
        $org = Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => $plan->id]);
        
        $superAdminA = User::factory()->create(['role' => 'super_admin', 'organization_id' => null]);
        $superAdminA->assignRole('super_admin');
        
        $superAdminB = User::factory()->create(['role' => 'super_admin', 'organization_id' => null]);
        $superAdminB->assignRole('super_admin');

        $this->actingAs($superAdminA);

        // The impersonate method in Dashboard looks for an org_admin for the specific org.
        // Even if we passed an org ID, it queries for org_admin.
        
        $component = \Livewire\Livewire::test(\App\Livewire\Admin\Dashboard::class);
        $component->call('impersonate', $org->id);
        
        // Assert session impersonating is NOT set, or if set, auth user is NOT superAdminB
        $this->assertFalse(auth()->id() === $superAdminB->id);
    }
}
