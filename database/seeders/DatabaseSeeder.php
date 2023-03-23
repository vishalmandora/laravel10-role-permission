<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ActiveSourcingRequest;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Employer;
use App\Models\MessageTemplate;
use App\Models\Team;
use App\Models\UnlockedContact;
use App\Models\User;
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
        $this->createCompany();
        $this->createEmployers();
        $this->createTeams();
        $this->createCampaigns();
        $this->createMessageTemplates();
    }

    private function createRoles()
    {
        Role::create(['name' => 'Business-Owner']);
        Role::create(['name' => 'Business-User']);
    }

    private function createPermission()
    {
        foreach (collect([Employer::class]) as $class) {
            foreach (collect(['view', 'edit']) as $permission) {
                $class = Str::camel(class_basename($class));

                Permission::create(['name' => "{$permission}:branch-level:{$class}"]);

                if ($permission == 'edit') {
                    Permission::create(['name' => "{$permission}:none:{$class}"]);
                }
            }
        }

        foreach (collect([Campaign::class, UnlockedContact::class]) as $class) {
            foreach (collect(['view', 'edit']) as $permission) {
                $class = Str::camel(class_basename($class));

                Permission::create(['name' => "{$permission}:branch-level:{$class}"]);
                Permission::create(['name' => "{$permission}:team-level:{$class}"]);
                Permission::create(['name' => "{$permission}:user-level:{$class}"]);

                if (($class == Str::camel(class_basename(Campaign::class)) && $permission == 'edit') || $class == Str::camel(class_basename(UnlockedContact::class))) {
                    Permission::create(['name' => "{$permission}:none:{$class}"]);
                }
            }
        }

        foreach (collect([ActiveSourcingRequest::class]) as $class) {
            foreach (collect(['write']) as $permission) {
                $class = Str::camel(class_basename($class));

                Permission::create(['name' => "{$permission}:all:{$class}"]);
                Permission::create(['name' => "{$permission}:none:{$class}"]);
            }
        }
    }

    private function createBusinessOwner()
    {
        User::factory()->create([
            'name' => 'Pascal Kremp',
            'email' => 'pascal@test.com',
        ])->assignRole('Business-Owner');
    }

    private function createBusinessUsers()
    {
        User::factory()->create([
            'name' => 'User A',
            'email' => 'user_a@test.com',
        ])->assignRole('Business-User')->givePermissionTo([
            'view:branch-level:employer',
            'edit:branch-level:employer',

            'view:branch-level:campaign',
            'edit:branch-level:campaign',

            'view:branch-level:unlockedContact',
            'edit:branch-level:unlockedContact',

            'write:all:activeSourcingRequest',
        ]);

        User::factory()->create([
            'name' => 'User B',
            'email' => 'user_b@test.com',
        ])->assignRole('Business-User')->givePermissionTo([
            'view:branch-level:employer',
            'edit:branch-level:employer',

            'view:team-level:campaign',
            'edit:team-level:campaign',

            'view:team-level:unlockedContact',
            'edit:team-level:unlockedContact',

            'write:none:activeSourcingRequest',
        ]);

        User::factory()->create([
            'name' => 'User C',
            'email' => 'user_c@test.com',
        ])->assignRole('Business-User')->givePermissionTo([
            'view:branch-level:employer',
            'edit:branch-level:employer',

            'view:user-level:campaign',
            'edit:user-level:campaign',

            'view:user-level:unlockedContact',
            'edit:user-level:unlockedContact',
        ]);

        User::factory()->create([
            'name' => 'User D',
            'email' => 'user_d@test.com',
        ])->assignRole('Business-User')->givePermissionTo([
            'view:branch-level:employer',
            'edit:branch-level:employer',

            'edit:none:campaign',

            'edit:none:unlockedContact',
        ]);

        User::factory()->create([
            'name' => 'User E',
            'email' => 'user_e@test.com',
        ])->assignRole('Business-User');

        User::factory()->create([
            'name' => 'User F',
            'email' => 'user_f@test.com',
        ])->assignRole('Business-User');

        User::factory()->create([
            'name' => 'User G',
            'email' => 'user_g@test.com',
        ])->assignRole('Business-User');
    }

    private function createCompany()
    {
        Company::factory()->create([
            'name' => 'Johanniter',
        ])->users()->sync(User::query()->pluck('id')->toArray());
    }

    private function createEmployers()
    {
        $company = Company::query()->first();

        $owner = $company->users()->role('Business-Owner')->first();

        foreach (collect(['Berlin', 'Munich', 'Wuppertal']) as $employer) {
            Employer::factory()->create([
                'name' => $employer,
                'owner_id' => $owner->id,
                'company_id' => $company->id,
            ]);
        }
    }

    private function createTeams()
    {
        $company = Company::query()->first();

        $employer = Employer::query()->where('name', 'Berlin')->first();

        Team::factory()->create([
            'name' => 'Team 1 - Heart station',
            'employer_id' => $employer->id,
            'company_id' => $company->id,
        ])->users()->attach([2, 3, 4, 5]);

        Team::factory()->create([
            'name' => 'Team 2 - Cancer station',
            'employer_id' => $employer->id,
            'company_id' => $company->id,
        ])->users()->attach([2, 6]);

        $employer = Employer::query()->where('name', 'Munich')->first();

        Team::factory()->create([
            'name' => 'Team 3 - Cancer station',
            'employer_id' => $employer->id,
            'company_id' => $company->id,
        ])->users()->attach([6, 7]);

        $employer = Employer::query()->where('name', 'Wuppertal')->first();

        Team::factory()->create([
            'name' => 'Team 4 - Children\'s station',
            'employer_id' => $employer->id,
            'company_id' => $company->id,
        ])->users()->attach([8]);
    }

    private function createCampaigns()
    {
        $company = Company::query()->first();

        $owner = $company->users()->role('Business-Owner')->first();

        $employer = Employer::query()->where('name', 'Berlin')->first();

        Campaign::factory()->create([
            'name' => 'Campaign 1 / Job Post 1',
            'employer_id' => $employer->id,
            'owner_id' => $owner->id,
            'company_id' => $company->id,
        ]);
    }

    private function createMessageTemplates()
    {
        $company = Company::query()->first();

        $owner = $company->users()->role('Business-Owner')->first();

        $employer = Employer::query()->where('name', 'Berlin')->first();

        MessageTemplate::factory()->create([
            'title' => 'Message Template 1',
            'description' => 'Message Description 1',
            'owner_id' => $owner->id,
            'employer_id' => $employer->id,
        ]);

        MessageTemplate::factory()->create([
            'title' => 'Message Template 2',
            'description' => 'Message Description 2',
            'owner_id' => $owner->id,
            'employer_id' => $employer->id,
        ]);

        $employer = Employer::query()->where('name', 'Munich')->first();

        MessageTemplate::factory()->create([
            'title' => 'Message Template 3',
            'description' => 'Message Description 3',
            'owner_id' => $owner->id,
            'employer_id' => $employer->id,
        ]);

        $employer = Employer::query()->where('name', 'Wuppertal')->first();

        MessageTemplate::factory()->create([
            'title' => 'Message Template 4',
            'description' => 'Message Description 4',
            'owner_id' => $owner->id,
            'employer_id' => $employer->id,
        ]);
    }
}
