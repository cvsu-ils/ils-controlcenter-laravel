<?php

namespace App\Providers;

use App\Models\LTX\Theses;
use App\Models\LTX\Cover;
use App\Models\LTX\FullText;
use App\Observers\LTX\ThesesObserver;
use App\Observers\LTX\FullTextObserver;
use App\Observers\LTX\CoverObserver;
use Illuminate\Support\ServiceProvider;

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
        Theses::observe(ThesesObserver::class);
        FullText::observe(FullTextObserver::class);
        Cover::observe(CoverObserver::class);
    }
}
