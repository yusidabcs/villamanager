<?php namespace Modules\Villamanager\Providers;

use Illuminate\Support\ServiceProvider;

class VillamanageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Villamanager\Repositories\VillaRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentVillaRepository(new \Modules\Villamanager\Entities\Villa());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Villamanager\Repositories\Cache\CacheVillaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Villamanager\Repositories\RateRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentRateRepository(new \Modules\Villamanager\Entities\Rate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Villamanager\Repositories\Cache\CacheRateDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Villamanager\Repositories\FacilityRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentFacilityRepository(new \Modules\Villamanager\Entities\Facility());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Villamanager\Repositories\Cache\CacheFacilityDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Villamanager\Repositories\ImageRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentImageRepository(new \Modules\Villamanager\Entities\Image());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Villamanager\Repositories\Cache\CacheImageDecorator($repository);
            }
        );


        $this->app->bind(
            'Modules\Villamanager\Repositories\BookingRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentBookingRepository(new \Modules\Villamanager\Entities\Booking());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Villamanager\Repositories\InquiryRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentInquiryRepository(new \Modules\Villamanager\Entities\Inquiry());

                if (! config('app.cache')) {
                    return $repository;
                }
                return $repository;
                //return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Villamanager\Repositories\DiscountRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentDiscountRepository(new \Modules\Villamanager\Entities\Discount());

                if (! config('app.cache')) {
                    return $repository;
                }
                return $repository;
                //return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Villamanager\Repositories\DisableDateRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentDisableDateRepository(new \Modules\Villamanager\Entities\DisableDate());

                if (! config('app.cache')) {
                    return $repository;
                }
                return $repository;
                //return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Villamanager\Repositories\AreaRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentAreaRepository(new \Modules\Villamanager\Entities\Area());

                if (! config('app.cache')) {
                    return $repository;
                }
                return $repository;
                //return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Villamanager\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Villamanager\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Villamanager\Entities\VillaCategory());

                if (! config('app.cache')) {
                    return $repository;
                }
                return $repository;
                //return new \Modules\Villamanager\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );




    }
}
