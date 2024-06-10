<?php

namespace App\Providers;

use App\Interfaces\ApplicantRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ApplicantRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class CandidatosProvider extends ServiceProvider
{
    protected $repositories = [
        UserRepositoryInterface::class => UserRepository::class,
        ApplicantRepositoryInterface::class => ApplicantRepository::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $repository)
        {
            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
