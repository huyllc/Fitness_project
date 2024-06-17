<?php

namespace App\Providers;

use App\Repositories\User\IUserProfile;
use App\Repositories\User\UserProfileRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Course\CourseRepositoryInterface::class,
            \App\Repositories\Course\CourseRepository::class,

        );

        $this->app->singleton(
            IUserProfile::class,
            UserProfileRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Enrollment\IEnrollmentRepository::class,
            \App\Repositories\Enrollment\EnrollmentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
