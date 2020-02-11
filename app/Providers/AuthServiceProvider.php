<?php

namespace App\Providers;
use App\Claim;
use App\Policies\ClaimPolicy;
use App\Product;
use App\Policies\ProductPolicy;
use App\Term;
use App\Policies\TermPolicy;
use App\ReasonReject;
use App\Policies\ReasonRejectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Claim::class => ClaimPolicy::class,
        Product::class => ProductPolicy::class,
        Term::class => TermPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->registerPolicies();
        Gate::define('viewLarecipe', function($user, $documentation) {
            return true;
        });
    }
}
