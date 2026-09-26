<?php

namespace App\Providers;

use App\Services\Shipping\StandardShippingModifier;
use Illuminate\Support\ServiceProvider;
use Lunar\Base\ShippingModifiers;
//panel
use Lunar\Admin\Support\Facades\LunarPanel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        LunarPanel::register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make(ShippingModifiers::class)
            ->add(StandardShippingModifier::class);
    }
}
