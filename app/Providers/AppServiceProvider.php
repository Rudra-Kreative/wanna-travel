<?php

namespace App\Providers;

use App\Helper\Country;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use Country;
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

        Blade::directive('getCountryName',function($code){
           $index =  array_search(strtoupper($code) , array_column($this->getCountryList(),'code'));
           $name = $this->getCountryList()[$index]['name'] ?? '';
           return "<?php echo Test; ?>";
           
        });
    }
}
