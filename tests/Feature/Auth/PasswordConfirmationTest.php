<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('http://admin.pulsedesk.test/confirm-password');

        $response
            ->assertSeeVolt('pages.auth.confirm-password')
            ->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('pages.auth.confirm-password')
            ->set('password', 'password');

        $component->call('confirmPassword');

        $component
            ->assertRedirect(route('dashboard', ['tenant' => $org->slug], absolute: false))
            ->assertHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('pages.auth.confirm-password')
            ->set('password', 'wrong-password');

        $component->call('confirmPassword');

        $component
            ->assertNoRedirect()
            ->assertHasErrors('password');
    }
}
