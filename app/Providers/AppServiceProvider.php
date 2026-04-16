<?php

namespace App\Providers;
use App\Models\Navbar;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          if (file_exists(app_path('helpers.php'))) {
        require_once app_path('helpers.php');
    }
    }

    /**
     * Bootstrap any application services.
     */
  public function boot()
{
    view()->composer('*', function ($view) {
        $menus = Navbar::where('status', 1)
                        ->orderBy('order')
                        ->get();

        $view->with('menus', $menus);
    });
}
}
