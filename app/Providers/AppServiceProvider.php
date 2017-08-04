<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('companies')) {
            $this->bootCompanyMenu();
        }
    }

    /**
     * Boot antvel menu.
     *
     * @return void
     */
    protected function bootCompanyMenu()
    {
        $menu = [];

        foreach ($this->app->make('category.repository.cahe')->categoriesWithProducts() as $value) {
            $menu[$value['id']] = $value;
        }

        View::share('categories_menu', $menu);
        View::share('main_company', \Antvel\Company\Models\Company::find(1));
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
