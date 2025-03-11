<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\repositoryInterface;
use App\Repository\usermanagementRepository;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(repositoryInterface::class,usermanagementRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('products.*', function ($view) {
        $view->with('categories', Category::all());
    });
    }
}
