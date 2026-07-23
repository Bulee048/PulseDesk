<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Plan;
use Spatie\Permission\Models\Role;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name' => 'org_admin']);
        Role::firstOrCreate(['name' => 'agent']);
        Role::firstOrCreate(['name' => 'customer']);
    }

    public function test_agent_cannot_access_other_organization_tickets()
    {
        $plan = Plan::create(['name' => 'Free', 'price_cents' => 0, 'ticket_limit_per_month' => 100]);
        $orgA = Organization::create(['name' => 'Org A', 'slug' => 'org-a', 'status' => 'active', 'plan_id' => $plan->id]);
        $orgB = Organization::create(['name' => 'Org B', 'slug' => 'org-b', 'status' => 'active', 'plan_id' => $plan->id]);

        $agentA = User::factory()->create(['organization_id' => $orgA->id]);
        $agentA->assignRole('agent');

        $customerB = User::factory()->create(['organization_id' => $orgB->id]);
        $categoryB = Category::create(['name' => 'Cat B', 'organization_id' => $orgB->id]);

        $ticketB = Ticket::create([
            'organization_id' => $orgB->id,
            'subject' => 'Org B Ticket',
            'description' => 'Test',
            'status' => 'open',
            'priority' => 'low',
            'category_id' => $categoryB->id,
            'customer_id' => $customerB->id,
        ]);

        $this->actingAs($agentA);

        // Attempt to access Org B ticket as Org A agent
        $response = $this->get('http://org-a.pulsedesk.test/tickets/' . $ticketB->id);
        
        $response->assertStatus(404);
    }
}
