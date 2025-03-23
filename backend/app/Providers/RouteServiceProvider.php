<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Yönlendirme yapılandırmasını yükleyin.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * API rotalarını yükleyin.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')  // API rotaları '/api' ile başlayacak
            ->middleware('api')  // API middleware'ini kullanacak
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));  // routes/api.php dosyasındaki rotaları yükle
    }

    /**
     * Web rotalarını yükleyin.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')  // Web middleware'ini kullanacak
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));  // routes/web.php dosyasındaki rotaları yükle
    }
}
