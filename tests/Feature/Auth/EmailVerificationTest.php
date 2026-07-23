<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('http://admin.pulsedesk.test/verify-email');

        $response
            ->assertSeeVolt('pages.auth.verify-email')
            ->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->unverified()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');

        Event::fake();

        \Illuminate\Support\Facades\URL::defaults(['tenant' => $org->slug]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', ['tenant' => $org->slug], absolute: false) . '?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $org = \App\Models\Organization::create(['name' => 'Test Org', 'slug' => 'test-org', 'status' => 'active', 'plan_id' => \App\Models\Plan::firstOrCreate(['slug' => 'free'], ['name' => 'Free', 'price_cents' => 0, 'agent_limit' => 3, 'ticket_limit' => 100])->id]);
        $user = User::factory()->unverified()->create(['organization_id' => $org->id]);
        $user->assignRole('customer');

        \Illuminate\Support\Facades\URL::defaults(['tenant' => $org->slug]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
