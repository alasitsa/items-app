<?php

namespace App\Providers;

use App\Models\Item;
use App\Observers\ItemObserver;
use App\Repositories\iface\IItemRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        IItemRepository::class => ItemRepository::class,
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
        Item::observe(ItemObserver::class);
    }
}
