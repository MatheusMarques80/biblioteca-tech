<?php

namespace App\Modules\Relatorios\Services;

use App\Modules\Relatorios\Interfaces\RelatorioAutorLivroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RelatorioAutorLivroService {

    public function __construct(private RelatorioAutorLivroRepositoryInterface $relatorioAutorLivroRepository)
    {
    }

    public function gerar (): Collection {
        $autores = $this->relatorioAutorLivroRepository->gerar();

        return $autores;
    }
}