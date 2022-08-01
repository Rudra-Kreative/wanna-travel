<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        
        Blade::directive('excerpt', function ($text, $len = 400) {
            return "<?php echo Str::limit($text, $len); ?>";
        });
        Blade::directive('excerptShort', function ($text) {
            return "<?php echo Str::limit($text, 100); ?>";
        });
    }
}
