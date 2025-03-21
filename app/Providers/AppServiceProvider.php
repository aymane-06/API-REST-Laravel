<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policy = [
        'App\Models\Offer' => 'App\Policies\OfferPolicy',
        'App\Models\Competences' => 'App\Policies\CompetencesPolicy',
        'App\Models\Application' => 'App\Policies\ApplicationPolicy',
    ];
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
