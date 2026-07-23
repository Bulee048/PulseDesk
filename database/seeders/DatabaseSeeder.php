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
        // 1. Seed Plans
        $freePlan = \App\Models\Plan::create([
            'name' => 'Free',
            'price_cents' => 0,
            'agent_limit' => 3,
            'ticket_limit_per_month' => 100,
        ]);
        
        $starterPlan = \App\Models\Plan::create([
            'name' => 'Starter',
            'price_cents' => 2900,
            'agent_limit' => 10,
            'ticket_limit_per_month' => 1000,
        ]);
        
        $proPlan = \App\Models\Plan::create([
            'name' => 'Pro',
            'price_cents' => 9900,
            'agent_limit' => null,
            'ticket_limit_per_month' => null,
        ]);

        // 2. Create Demo Organization
        $demoOrg = \App\Models\Organization::create([
            'name' => 'Demo Co',
            'slug' => 'demo-co',
            'status' => 'active',
            'plan_id' => $freePlan->id,
        ]);

        // 3. Create Spatie Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $orgAdminRole = Role::firstOrCreate(['name' => 'org_admin']);
        $agentRole = Role::firstOrCreate(['name' => 'agent']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // 4. Seed Categories for Demo Org
        $categories = ['Support', 'Billing', 'Sales', 'Technical', 'General'];
        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
                'organization_id' => $demoOrg->id,
            ]);
        }

        // 5. Create users for Demo Org
        $users = User::factory(15)->create([
            'organization_id' => $demoOrg->id,
        ]);
        foreach ($users as $user) {
            $user->assignRole($user->role);
        }

        // 6. Super Admin (No Org)
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@pulsedesk.local',
            'role' => 'super_admin',
            'organization_id' => null,
        ]);
        $superAdmin->assignRole('super_admin');
        
        // 7. Demo Users for easy login (Assigned to Demo Org)
        $demoCustomer = User::factory()->create([
            'name' => 'Demo Customer', 
            'email' => 'customer@demo.com', 
            'role' => 'customer',
            'organization_id' => $demoOrg->id,
        ]);
        $demoCustomer->assignRole('customer');
        
        $demoAgent = User::factory()->create([
            'name' => 'Demo Agent', 
            'email' => 'agent@demo.com', 
            'role' => 'agent',
            'organization_id' => $demoOrg->id,
        ]);
        $demoAgent->assignRole('agent');
        
        $demoAdmin = User::factory()->create([
            'name' => 'Demo Org Admin', 
            'email' => 'admin@demo.com', 
            'role' => 'org_admin',
            'organization_id' => $demoOrg->id,
        ]);
        $demoAdmin->assignRole('org_admin');

        // 8. Seed Demo Knowledge Base Article
        \App\Models\KnowledgeBaseArticle::create([
            'organization_id' => $demoOrg->id,
            'category_id' => \App\Models\Category::where('organization_id', $demoOrg->id)->where('name', 'Support')->first()->id ?? null,
            'title' => 'Welcome to our Knowledge Base',
            'slug' => 'welcome-to-our-knowledge-base',
            'body' => 'This is a sample article demonstrating the capabilities of the Knowledge Base. If you are still stuck, you can always open a ticket!',
            'published' => true,
        ]);
    }
}
