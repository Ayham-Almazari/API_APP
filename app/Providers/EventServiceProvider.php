<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Factory;
use App\Models\FactoryOrder;
use App\Models\Order;
use App\Models\Owner;
use App\Models\UsersProfiles;
use App\Observers\AdminObserver;
use App\Observers\BuyerObserver;
use App\Observers\FactoriesObserver;
use App\Observers\OrderObserver;
use App\Observers\OwnerObserver;
use App\Observers\UsersProfilesObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Buyer::observe(BuyerObserver::class);
        Admin::observe(AdminObserver::class);
        Owner::observe(OwnerObserver::class);
        Order::observe(OrderObserver::class);
        Factory::observe(FactoriesObserver::class);
        UsersProfiles::observe(UsersProfilesObserver::class);
    }
}
