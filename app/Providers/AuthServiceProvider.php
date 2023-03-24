<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Campaign;
use App\Models\Employer;
use App\Models\UnlockedContact;
use App\Policies\CampaignPolicy;
use App\Policies\EmployerPolicy;
use App\Policies\UnlockedContactPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //         'App\Models\Model' => 'App\Policies\ModelPolicy',
        Campaign::class => CampaignPolicy::class,
        Employer::class => EmployerPolicy::class,
        UnlockedContact::class => UnlockedContactPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
