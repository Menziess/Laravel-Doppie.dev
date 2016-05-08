<?php

namespace App\Providers;

use App\User;
use App\Organization;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user) {
            $user->profile()->create([]);
            $user->projects()->create([
                'name' => 'Bucketlist',
                'header' => 'Here comes a list of things that I\'m about to achieve in my life!',
            ]);
        });

        Organization::created(function ($organization) {
            $organization->projects()->create([
                'name' => 'Setting up my organization',
                'header' => 'Rolin\' rolin\' rolin\'...',
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
