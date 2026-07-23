<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');

        $response = $this
            ->actingAs($user)
            ->get('http://test-org.pulsedesk.test/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Test User')
            ->set('email', $user->email)
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'password')
            ->call('deleteUser');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');
        $this->app->instance(\App\Models\Organization::class, $org);

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'wrong-password')
            ->call('deleteUser');

        $component
            ->assertHasErrors('password')
            ->assertNoRedirect();

        $this->assertNotNull($user->fresh());
    }
}
