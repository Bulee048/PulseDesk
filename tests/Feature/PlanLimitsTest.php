<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

class PlanLimitsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'customer']);
    }

    public function test_ticket_limit_enforced_at_creation()
    {
        $plan = Plan::create([
            'name' => 'Tiny Plan',
            'price_cents' => 0,
            'ticket_limit_per_month' => 1
        ]);

        $org = Organization::create(['name' => 'Tiny Org', 'slug' => 'tiny-org', 'status' => 'active', 'plan_id' => $plan->id]);
        $this->app->instance(\App\Models\Organization::class, $org);
        
        $customer = User::factory()->create(['organization_id' => $org->id]);
        $customer->assignRole('customer');
        
        $category = Category::create(['name' => 'Support', 'organization_id' => $org->id]);

        // Create the 1 allowed ticket
        Ticket::create([
            'organization_id' => $org->id,
            'subject' => 'Ticket 1',
            'description' => 'Test',
            'status' => 'open',
            'priority' => 'low',
            'category_id' => $category->id,
            'customer_id' => $customer->id,
        ]);

        $this->actingAs($customer);

        Livewire::withQueryParams(['tenant' => 'tiny-org'])
            ->test(\App\Livewire\Customer\CreateTicket::class)
            ->set('subject', 'Ticket 2')
            ->set('description', 'This should fail limit')
            ->set('category_id', $category->id)
            ->set('priority', 'low')
            ->call('save')
            ->assertHasErrors(['limit']);
    }
}
