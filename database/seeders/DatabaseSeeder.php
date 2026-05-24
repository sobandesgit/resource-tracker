<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Item;
use App\Models\Log;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        // Create regular users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        // Create settings for each user
        UserSetting::create([
            'user_id' => $admin->id,
            'email_notifications' => true,
            'timezone' => 'UTC',
            'language' => 'en',
        ]);

        UserSetting::create([
            'user_id' => $user1->id,
            'email_notifications' => true,
            'timezone' => 'Africa/Lagos',
            'language' => 'en',
        ]);

        UserSetting::create([
            'user_id' => $user2->id,
            'email_notifications' => false,
            'timezone' => 'Africa/Lagos',
            'language' => 'en',
        ]);

        // Create groups (admin creates these)
        $group1 = Group::create([
            'name' => 'Engineering Team',
            'description' => 'Core engineering team members',
        ]);

        $group2 = Group::create([
            'name' => 'Design Team',
            'description' => 'UI/UX and product design team',
        ]);

        // Assign users to groups
        $group1->users()->attach([$admin->id, $user1->id]);
        $group2->users()->attach([$user1->id, $user2->id]);

        // Create items for each user
        $item1 = Item::create([
            'user_id' => $user1->id,
            'name' => 'Complete project documentation',
            'details' => 'Write full API documentation for the resource tracker',
            'is_completed' => false,
        ]);

        $item2 = Item::create([
            'user_id' => $user1->id,
            'name' => 'Set up CI/CD pipeline',
            'details' => 'Configure automated testing and deployment',
            'is_completed' => true,
        ]);

        $item3 = Item::create([
            'user_id' => $user2->id,
            'name' => 'Design landing page',
            'details' => 'Create mockups for the new landing page',
            'is_completed' => false,
        ]);

        // Create logs
        Log::create([
            'user_id' => $user1->id,
            'item_id' => $item1->id,
            'action' => 'created',
            'note' => 'Started working on documentation',
        ]);

        Log::create([
            'user_id' => $user1->id,
            'item_id' => $item2->id,
            'action' => 'completed',
            'note' => 'Pipeline is fully configured and tested',
        ]);

        Log::create([
            'user_id' => $user2->id,
            'item_id' => $item3->id,
            'action' => 'created',
            'note' => 'Initial mockups started',
        ]);
    }
}