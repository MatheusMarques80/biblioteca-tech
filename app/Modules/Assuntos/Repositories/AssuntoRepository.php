<?php

namespace App\Modules\Assuntos\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Assuntos\Interfaces\AssuntoRepositoryInterface;
use App\Modules\Assuntos\Models\Assunto;

class AssuntoRepository implements AssuntoRepositoryInterface {
    
    public function todos(): Collection
    {
        $assuntos = Assunto::query()
        ->orderBy('descricao')
        ->select(['id', 'descricao'])
        ->get();

        return $assuntos;
    }

    public function buscarPorId(int $id): ?Assunto
    {
        return Assunto::find($id);
    }

    public function criar(array $dados): Assunto
    {
        $assuntos = new Assunto($dados);
        $assuntos->save();

        return $assuntos;
    }

    public function atualizar(Assunto $assunto, array $dados): Assunto
    {
        $assunto->update($dados);
        return $assunto;
    }

    public function excluir(int $id): bool
    {
        return Assunto::where('id', $id)->delete();
    }
}