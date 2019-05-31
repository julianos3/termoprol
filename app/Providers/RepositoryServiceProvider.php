<?php

namespace AgenciaS3\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\AgenciaS3\Repositories\UserRepository::class, \AgenciaS3\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\ConfigurationRepository::class, \AgenciaS3\Repositories\ConfigurationRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\FormRepository::class, \AgenciaS3\Repositories\FormRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\FormEmailRepository::class, \AgenciaS3\Repositories\FormEmailRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\NewsletterRepository::class, \AgenciaS3\Repositories\NewsletterRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\PageRepository::class, \AgenciaS3\Repositories\PageRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\PageImageRepository::class, \AgenciaS3\Repositories\PageImageRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\LandingPageRepository::class, \AgenciaS3\Repositories\LandingPageRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\LandingPageProductRepository::class, \AgenciaS3\Repositories\LandingPageProductRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\LandingPageContactRepository::class, \AgenciaS3\Repositories\LandingPageContactRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\BannerRepository::class, \AgenciaS3\Repositories\BannerRepositoryEloquent::class);
        $this->app->bind(\AgenciaS3\Repositories\BannerMobileRepository::class, \AgenciaS3\Repositories\BannerMobileRepositoryEloquent::class);
        //:end-bindings:
    }
}
