<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('http://admin.pulsedesk.test/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('tickets.index', ['tenant' => $org->slug]));

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_navigation_menu_can_be_rendered(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $response = $this->get('http://test-org.pulsedesk.test/tickets');

        $response
            ->assertOk()
            ->assertSeeVolt('layout.navigation');
    }

    public function test_users_can_logout(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
