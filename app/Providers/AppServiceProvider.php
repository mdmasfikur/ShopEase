<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as Faker;

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
        //PlaceHolderImage
        Blade::directive('placeholderImage', function ($productName) {
            $faker = Faker::create();
            $productName = trim($productName, "'");
            $placeholderUrl = $faker->imageUrl(640, 480, $productName,false);
            return "<?php echo '$placeholderUrl'; ?>";
        });
    }
}
