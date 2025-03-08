<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            \App\Domain\Repositories\StudentRepositoryInterface::class,
            \App\Infrastructure\Repositories\StudentRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\AddressRepositoryInterface::class,
            \App\Infrastructure\Repositories\AddressRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\AcademicQualificationRepositoryInterface::class,
            \App\Infrastructure\Repositories\AcademicQualificationRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\ApplicationRepositoryInterface::class,
            \App\Infrastructure\Repositories\ApplicationRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\ApplicationAddressRepositoryInterface::class,
            \App\Infrastructure\Repositories\ApplicationAddressRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface::class,
            \App\Infrastructure\Repositories\ApplicationAcademicQualificationRepository::class
        );

        $this->app->bind(
            \App\Domain\Repositories\StudentProfileRepositoryInterface::class,
            \App\Infrastructure\Repositories\StudentProfileRepository::class
        );

        $this->app->bind(
            \App\Domain\Services\StudentService::class,
            function ($app) {
                return new \App\Domain\Services\StudentService(
                    $app->make(\App\Domain\Repositories\StudentRepositoryInterface::class),
                    $app->make(\App\Domain\Repositories\StudentProfileRepositoryInterface::class),
                    // $app->make(\App\Domain\Repositories\ApplicationAddressRepositoryInterface::class),
                    // $app->make(\App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface::class)
                    $app->make(\App\Domain\Repositories\AddressRepositoryInterface::class),
                    $app->make(\App\Domain\Repositories\AcademicQualificationRepositoryInterface::class)
                );
            }
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
