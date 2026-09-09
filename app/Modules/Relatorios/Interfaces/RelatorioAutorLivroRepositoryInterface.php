<?php

namespace App\Modules\Relatorios\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface RelatorioAutorLivroRepositoryInterface {
    public function gerar(): Collection;
}