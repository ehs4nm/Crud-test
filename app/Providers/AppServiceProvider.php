<?php

namespace App\Providers;

use App\Domains\Factories\CustomerFactory;
use App\Domains\Interfaces\CustomerFactoryInterface;
use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class,
        );

        $this->app->bind(
            CustomerFactoryInterface::class,
            CustomerFactory::class,
        );

        // $this->app
        //     ->when(HttpControllers\CustomerController::class)
        //     ->needs(UseCases\CreateCustomer\CreateCustomerInputPort::class)
        //     ->give(function ($app) {
        //         return $app->make(UseCases\CreateCustomer\CreateCustomerInteractor::class, [
        //             'output' => $app->make(Presenters\CreateCustomerHttpPresenter::class),
        //         ]);
        //     });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
