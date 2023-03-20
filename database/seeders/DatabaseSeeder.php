<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campaign;
use App\Models\Employer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createRoles();
        $this->createPermission();
        $this->createBusinessOwner();
        $this->createBusinessUsers();
        $this->createTeamsAndAssignUsers();
    }

    private function createRoles()
    {
        Role::create(['name' => 'Business-Owner']);
        Role::create(['name' => 'Business-User']);
    }

    private function createPermission()
    {
        foreach (collect([Employer::class, Campaign::class]) as $class) {
            foreach (collect(['create', 'edit', 'delete']) as $permission) {
                $class = Str::camel(class_basename($class));

                Permission::create(['name' => "{$permission}:everything:{$class}"]);
                Permission::create(['name' => "{$permission}:owned:{$class}"]);
                Permission::create(['name' => "{$permission}:ownedByTeamMember:{$class}"]);
            }
        }

        Permission::create(['name' => 'edit:everything:unlockedContact']);
        Permission::create(['name' => 'edit:owned:unlockedContact']);
        Permission::create(['name' => 'edit:ownedByTeamMember:unlockedContact']);
    }

    private function createBusinessOwner()
    {
        \App\Models\User::factory()->create([
            'name' => 'Pascal Kremp',
            'email' => 'pascal@test.com',
        ])->assignRole('Business-Owner');
    }

    private function createBusinessUsers()
    {
        \App\Models\User::factory()->create([
            'name' => 'Silvan',
            'email' => 'silvan@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'Nora',
            'email' => 'nora@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'Sami',
            'email' => 'sami@test.com',
        ])->assignRole('Business-User');
    }

    private function createTeamsAndAssignUsers()
    {
        \App\Models\Team::factory()->create([
            'name' => 'Super Admin',
        ])->users()->attach(1);

        \App\Models\Team::factory()->create([
            'name' => 'CSM',
        ])->users()->attach([2, 3]);

        \App\Models\Team::factory()->create([
            'name' => 'Accounting',
        ])->users()->attach(4);
    }
}
