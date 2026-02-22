<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->routes(function () {
            if (file_exists(base_path('routes/api.php'))) {
                Route::prefix('api')
                    ->middleware('api')
                    ->group(base_path('routes/api.php'));
            }

            if (file_exists(base_path('routes/web.php'))) {
                Route::middleware('web')
                    ->group(base_path('routes/web.php'));
            }
        });
    }
}
