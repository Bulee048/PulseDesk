<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles and permissions for tests if database is migrated
        if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $roles = ['super_admin', 'org_admin', 'agent', 'customer'];
            foreach ($roles as $role) {
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
            }
        }
        
        // Seed plans for tests
        if (\Illuminate\Support\Facades\Schema::hasTable('plans')) {
            if (!\App\Models\Plan::where('slug', 'free')->exists()) {
                \App\Models\Plan::create([
                    'name' => 'Free',
                    'slug' => 'free',
                    'price_cents' => 0,
                    'agent_limit' => 3,
                    'ticket_limit' => 100,
                ]);
            }
        }
    }
}
