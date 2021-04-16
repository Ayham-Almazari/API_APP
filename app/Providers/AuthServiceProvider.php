<?php

namespace App\Providers;

use App\Models\Factory;
use App\Policies\FactoryPolicy;
use Illuminate\Auth\Access\Response;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
         Factory::class => FactoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(fn($user)=>$user->isAdmin()?true:null);

       /* Gate::define('view-factory',function ($user,$fac){
        return $user->isOwner()&&($user->id==$fac->owner->id);
          });*/
    }
}
