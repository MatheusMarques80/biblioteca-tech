<?php

namespace App\Modules\Livros\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Livros\Interfaces\LivroRepositoryInterface;
use App\Modules\Livros\Models\Livro;

class LivroRepository implements LivroRepositoryInterface {
    
    public function todos(): Collection
    {
        $assuntos = Livro::with(['autores', 'assuntos'])
        ->orderBy('titulo')
        ->select(['id', 'titulo', 'editora', 'edicao', 'ano_publicacao', 'valor'])
        ->get();

        return $assuntos;
    }

    public function buscarPorId(int $id): ?Livro
    {
        return Livro::find($id);
    }

    public function criar(array $dados): Livro
    {
        $assuntos = new Livro($dados);
        $assuntos->save();

        return $assuntos;
    }

    public function atualizar(Livro $assunto, array $dados): Livro
    {
        $assunto->update($dados);
        return $assunto;
    }

    public function excluir(int $id): bool
    {
        return Livro::where('id', $id)->delete();
    }

    public function cadastrarAutores(Livro $livro, array $autorIds): void
    {
        $livro->autores()->sync($autorIds);
    }

    public function cadastrarAssuntos(Livro $livro, array $assuntos): void
    {
        $livro->assuntos()->sync($assuntos);
    }
}