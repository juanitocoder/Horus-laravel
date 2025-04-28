<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cart = Auth::user()->cart()->with('items')->first();
                $totalItems = $cart ? $cart->items->sum('quantity') : 0;
                $view->with('cartItemCount', $totalItems);
            } else {
                $view->with('cartItemCount', 0);
            }
        });
    }
}
