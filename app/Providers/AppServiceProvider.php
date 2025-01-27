<?php

namespace App\Providers;

use App\Models\Voter;
use App\Models\VoterOrganization;
use App\Policies\UserPolicy;
use App\Policies\VoterOrganizationPolicy;
use App\Policies\VoterPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Voter::class => VoterPolicy::class,
        User::class => UserPolicy::class,
        VoterOrganization::class => VoterOrganizationPolicy::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
    }
}
