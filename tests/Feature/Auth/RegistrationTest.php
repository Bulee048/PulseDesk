<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $this->app->instance(\App\Models\Organization::class, $org);

        $response = $this->get('http://test-org.pulsedesk.test/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_new_users_can_register(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $this->app->instance(\App\Models\Organization::class, $org);

        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect(route('tickets.index', ['tenant' => $org->slug]));

        $this->assertAuthenticated();
    }
}
