<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2, '.', ' '); ?>";
        });
        //
        //Paginator::useBootstrap();
        //Paginator::useTailwind();
       // Paginator::defaultSimpleView('view-name');
    }
}
