<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Missile;
use App\Models\Partie;
use App\Policies\MissilePolicy;
use App\Policies\PartiePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Missile' => 'App\Policies\MissilePolicy',
        Missile::class => MissilePolicy::class,
        //'App\Models\Partie' => 'App\Policies\PartiePolicy',
        Partie::class => PartiePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
