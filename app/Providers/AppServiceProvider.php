<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Observers\PemijamanObserver;
use App\Observers\PengembalianObserver;
use App\Observers\AlatObserver;
use Appp\Models\Alat;

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
        
    }
}
