<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Spatie Roles
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $agentRole = Role::firstOrCreate(['name' => 'agent']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 5 Categories
        $categories = ['Support', 'Billing', 'Sales', 'Technical', 'General'];
        foreach ($categories as $category) {
            \App\Models\Category::create(['name' => $category]);
        }

        // 15 Users
        $users = User::factory(15)->create();
        foreach ($users as $user) {
            $user->assignRole($user->role); // Since we set the string 'role' in factory, assign the matching Spatie role
        }

        // 1 Specific Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@pulsedesk.local',
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');
        
        // Demo Users for easy login
        $demoCustomer = User::factory()->create(['name' => 'Demo Customer', 'email' => 'customer@demo.com', 'role' => 'customer']);
        $demoCustomer->assignRole('customer');
        
        $demoAgent = User::factory()->create(['name' => 'Demo Agent', 'email' => 'agent@demo.com', 'role' => 'agent']);
        $demoAgent->assignRole('agent');
        
        $demoAdmin = User::factory()->create(['name' => 'Demo Admin', 'email' => 'admin@demo.com', 'role' => 'admin']);
        $demoAdmin->assignRole('admin');
    }
}
