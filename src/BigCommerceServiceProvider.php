<?php

namespace CoalitionTech\BigCommerceAPI;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BigCommerceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('bigcommerce-api-laravel')
            ->hasConfigFile();
    }

    /**
     * @throws InvalidPackage
     */
    public function register()
    {
        parent::register();

        $this->app->bind('bigcommerce-client', function () {
            new BigCommerce();
        });

        return $this;
    }
}