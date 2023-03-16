<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $this->createTeams();
    }

    private function createRoles()
    {
        Role::create(['name' => 'Business-Owner']);
        Role::create(['name' => 'Business-User']);
    }

    private function createPermission()
    {
        Permission::create(['name' => 'create:employer']);
        Permission::create(['name' => 'edit:employer']);
        Permission::create(['name' => 'delete:employer']);

        Permission::create(['name' => 'create:campaign']);
        Permission::create(['name' => 'edit:campaign']);
        Permission::create(['name' => 'delete:campaign']);

        Permission::create(['name' => 'edit:unlocked-contacts']);
    }

    private function createTeams()
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
}
