<?php

namespace App\Modules\Autores\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Autores\Interfaces\AutorRepositoryInterface;
use App\Modules\Autores\Models\Autor;

class AutorRepository implements AutorRepositoryInterface {
    
    public function todos(): Collection
    {
        $autores = Autor::query()
        ->orderBy('nome')
        ->select(['id', 'nome'])
        ->get();

        return $autores;
    }

    public function buscarPorId(int $id): ?Autor
    {
        return Autor::find($id);
    }

    public function criar(array $dados): Autor
    {
        $autores = new Autor($dados);
        $autores->save();

        return $autores;
    }

    public function atualizar(Autor $autor, array $dados): Autor
    {
        $autor->update($dados);
        return $autor;
    }

    public function excluir(int $id): bool
    {
        return Autor::where('id', $id)->delete();
    }
}