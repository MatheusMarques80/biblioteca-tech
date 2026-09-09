<?php

namespace App\Providers;

use App\Modules\Assuntos\Interfaces\AssuntoRepositoryInterface;
use App\Modules\Assuntos\Repositories\AssuntoRepository;
use App\Modules\Autores\Interfaces\AutorRepositoryInterface;
use App\Modules\Autores\Repositories\AutorRepository;
use App\Modules\Livros\Interfaces\LivroRepositoryInterface;
use App\Modules\Livros\Repositories\LivroRepository;
use App\Modules\Relatorios\Interfaces\RelatorioAutorLivroRepositoryInterface;
use App\Modules\Relatorios\Repositories\RelatorioAutorLivroRepository;
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
            AutorRepositoryInterface::class,
            AutorRepository::class
        );

        $this->app->bind(
            AssuntoRepositoryInterface::class,
            AssuntoRepository::class
        );

        $this->app->bind(
            LivroRepositoryInterface::class,
            LivroRepository::class
        );

        $this->app->bind(
            RelatorioAutorLivroRepositoryInterface::class,
            RelatorioAutorLivroRepository::class
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
