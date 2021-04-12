<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Factory;
use App\Models\Owner;
use Illuminate\Support\Arr;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
//    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
     protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api/v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('api/v1/dashboard')
                ->middleware('api')
                ->namespace($this->namespace.'\\API\\Admin')
                ->group(base_path('routes/admins.php'));

            Route::prefix('api/v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/auth.php'));

            Route::prefix('api/v1')
                ->middleware(['api'])
                ->namespace($this->namespace.'\\API\\OwnerOfFactoryControllers')
                ->group(base_path('routes/factory.php'));

            Route::prefix('api/v1')
                ->middleware(['api'])
                ->namespace($this->namespace.'\\API\\CategoriesOfFactoriesControllers')
                ->group(base_path('routes/category.php'));

            Route::prefix('api/v1')
                ->middleware(['api'])
                ->namespace($this->namespace.'\\API\\OwnerControllers')
                ->group(base_path('routes/owner.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });


    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
