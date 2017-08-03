<?php

namespace App\Providers;

use Antvel\Company\Models\Company;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use Antvel\Categories\CategoriesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $table = 'companies';

        if (\Schema::hasTable($table)) {

            $main_company = Company::find(1);

            $categories_menu = \Cache::remember('categories_parents', 25, function () {
                return (new CategoriesRepository)->categoriesWithProducts()->toArray();
            });

            $menu = [];

            foreach ($categories_menu as $value) {
                $menu[$value['id']] = $value;
            }

            \View::share('main_company', $main_company);
            \View::share('categories_menu', $menu);
        }
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
