<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {

            $menus = Menu::with([
                'children' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('order');
                }
            ])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

            $view->with('menus', $menus);
        });
    }
}
