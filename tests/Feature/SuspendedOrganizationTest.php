<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\Plan;

class SuspendedOrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_suspended_organization_returns_suspended_page()
    {
        $plan = Plan::create(['name' => 'Free', 'price_cents' => 0, 'ticket_limit_per_month' => 100]);
        $org = Organization::create(['name' => 'Suspended Org', 'slug' => 'suspended-org', 'status' => 'suspended', 'plan_id' => $plan->id]);
        
        $response = $this->get('http://suspended-org.pulsedesk.test/login');
        
        $response->assertStatus(403);
        $response->assertViewIs('errors.suspended');
    }
}
