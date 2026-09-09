<?php

namespace App\Modules\Relatorios\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Relatorios\Interfaces\RelatorioAutorLivroRepositoryInterface;
use App\Modules\Relatorios\Models\RelatorioAutorLivroView;

class RelatorioAutorLivroRepository implements RelatorioAutorLivroRepositoryInterface {
    
    public function gerar(): Collection
    {
        return RelatorioAutorLivroView::all();
    }
}