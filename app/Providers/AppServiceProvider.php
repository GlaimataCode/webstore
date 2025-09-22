<?php

namespace App\Providers;

use App\Actions\ValidateCartStock;
use App\Models\User;
use Illuminate\Support\Number;
use App\Services\SessionCartService;
use Illuminate\Support\Facades\Gate;
use App\Contract\CartServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

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

       Gate::define('is_stock_available', function(User $user = null){
        try {
            ValidateCartStock::run();
            return true;
       } catch (ValidationException $e) {
            session()->flash('error', $e->getMessage());
            return false;
       }
        });
    }
}