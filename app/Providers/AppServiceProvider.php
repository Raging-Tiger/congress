<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Event;
use Carbon\Carbon;
use View;
use ConsoleTVs\Charts\Registrar as Charts;

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
    public function boot(Charts $charts)
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        if(Schema::hasTable('events'))
        {
           $current_events = Event::whereDate('end_date', '>=', Carbon::now())->get();
            View::share('current_events', $current_events); 
        }
    }
}
