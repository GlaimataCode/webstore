<?php

namespace App\Providers;

use App\Contract\CartServiceInterface;
use App\Services\SessionCartService;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, SessionCartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Model::Unguard();
       Number::useCurrency('USD', '$', 0);
    }
}
