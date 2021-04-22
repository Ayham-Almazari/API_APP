<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Factory;
use App\Models\Product;
use App\Policies\CategoryPolicy;
use App\Policies\FactoryPolicy;
use App\Policies\OfferPolicy;
use App\Policies\ProductPolicy;
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
         Product::class => ProductPolicy::class,
         Category::class => CategoryPolicy::class,
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

        Gate::define('authorize-owner-product',[ProductPolicy::class,'AuthorizeProductForOwner']);
        Gate::define('authorize-owner-factory',[FactoryPolicy::class,'AuthorizeFactoryForOwner']);
        Gate::define('authorize-owner-category',[CategoryPolicy::class,'AuthorizeCategoryForOwner']);
        Gate::define('authorize-owner-offer',[OfferPolicy::class,'AuthorizeOfferForOwner']);
    }
}
