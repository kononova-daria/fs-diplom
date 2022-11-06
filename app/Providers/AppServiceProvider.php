<?php

namespace App\Providers;

use App\Repositories\FilmRepository;
use App\Repositories\FilmSessionRepository;
use App\Repositories\HallRepository;
use App\Repositories\Interfaces\FilmRepositoryInterface;
use App\Repositories\Interfaces\FilmSessionRepositoryInterface;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PlaceRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            FilmRepositoryInterface::class,
            FilmRepository::class
        );

        $this->app->bind(
            FilmSessionRepositoryInterface::class,
            FilmSessionRepository::class
        );

        $this->app->bind(
            HallRepositoryInterface::class,
            HallRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            PlaceRepositoryInterface::class,
            PlaceRepository::class
        );
    }

    public function boot(): void
    {
        Validator::extend('obj_with_hall', static function ($attribute, $value, $parameters, $validator) {
            return count($value) && array_key_exists('hall_id', $value[0]);
        });
    }
}
