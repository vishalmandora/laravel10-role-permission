<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Employer;
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
//        $this->createTeamsAndAssignUsers();
    }

    private function createRoles()
    {
        Role::create(['name' => 'Business-Owner']);
        Role::create(['name' => 'Business-User']);
    }

    private function createPermission()
    {
        foreach (collect([Employer::class, Campaign::class, UnlockedContact::class]) as $class) {
            foreach (collect(['create', 'view', 'edit', 'delete']) as $permission) {
                $class = Str::camel(class_basename($class));

                Permission::create(['name' => "{$permission}:everything:{$class}"]);
                Permission::create(['name' => "{$permission}:owned:{$class}"]);
                Permission::create(['name' => "{$permission}:ownedByTeamMember:{$class}"]);
                Permission::create(['name' => "{$permission}:none:{$class}"]);
            }
        }
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
            'name' => 'User A',
            'email' => 'user_a@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User B',
            'email' => 'user_b@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User C',
            'email' => 'user_c@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User D',
            'email' => 'user_d@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User E',
            'email' => 'user_e@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User F',
            'email' => 'user_f@test.com',
        ])->assignRole('Business-User');

        \App\Models\User::factory()->create([
            'name' => 'User G',
            'email' => 'user_g@test.com',
        ])->assignRole('Business-User');
    }

    private function createCompany()
    {
        $company = Company::factory()->create([
            'name' => 'Johanniter',
        ]);

        $userIds = User::query()->pluck('id')->toArray();

        $company->users()->sync($userIds);
    }

    private function createEmployers()
    {
        Employer::factory()->create([
            'name' => 'Berlin',
            'owner_id' => User::first()->id,
            'company_id' => Company::first()->id,
        ]);

        Employer::factory()->create([
            'name' => 'Munich',
            'owner_id' => User::first()->id,
            'company_id' => Company::first()->id,
        ]);

        Employer::factory()->create([
            'name' => 'Wuppertal',
            'owner_id' => User::first()->id,
            'company_id' => Company::first()->id,
        ]);
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
        $employer = Employer::query()->where('name', 'Berlin')->first();

        Campaign::factory()->create([
            'name' => 'Campaign 1',
            'employer_id' => $employer->id,
            'owner_id' => User::first()->id,
            'company_id' => Company::first()->id,
        ]);
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

    private function createEmployersAndCampaigns()
    {
        $emp1 = Employer::factory()->create([
            'name' => 'Employer 1',
            'owner_id' => 1,
        ]);

        $campaign1 = Campaign::factory()->create([
            'employer_id' => $emp1,
            'name' => 'Campaign 1',
        ]);

        $campaign2 = Campaign::factory()->create([
            'employer_id' => $emp1,
            'name' => 'Campaign 2',
        ]);

        $emp2 = Employer::factory()->create([
            'name' => 'Employer 1',
            'owner_id' => 2,
        ]);

        $campaign3 = Campaign::factory()->create([
            'employer_id' => $emp2,
            'name' => 'Campaign 3',
        ]);

        $campaign4 = Campaign::factory()->create([
            'employer_id' => $emp2,
            'name' => 'Campaign 4',
        ]);
    }
}
