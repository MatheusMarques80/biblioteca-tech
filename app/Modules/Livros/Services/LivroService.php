<?php

namespace App\Modules\Livros\Services;

use App\Modules\Livros\Interfaces\LivroRepositoryInterface;
use App\Modules\Livros\Models\Livro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class LivroService {

    public function __construct(private LivroRepositoryInterface $livroRepository)
    {
    }

    public function listarTodos (): Collection {
        $livros = $this->livroRepository->todos();
        return $livros;
    }

    public function listarPorId (int $id): Livro {
        $livro = $this->livroRepository->buscarPorId($id);

        if (!isset($livro)) {
            throw new ModelNotFoundException('Livro não encontrado');
        }

        return $livro;
    }

    public function atualizar(array $dados, array $autorIds, array $assuntoIds,int $id): Livro {

        $livro = $this->listarPorId($id);
        
        return DB::transaction(function () use($dados, $autorIds, $assuntoIds, $id, $livro) {
            $this->livroRepository->atualizar($livro, $dados);
            $this->livroRepository->cadastrarAutores($livro, $autorIds);
            $this->livroRepository->cadastrarAssuntos($livro, $assuntoIds);
            return $livro;
        });

    }

    public function cadastrar(array $dados, array $autorIds, array $assuntoIds): Livro {
        return DB::transaction(function () use($dados, $autorIds, $assuntoIds) {
            $livro = $this->livroRepository->criar($dados);
            if (count($autorIds) > 0) {
                $this->livroRepository->cadastrarAutores($livro, $autorIds);
            }
            if (count($assuntoIds) > 0) {
                $this->livroRepository->cadastrarAssuntos($livro, $assuntoIds);
            }
            return $livro;
        });

    }

    public function excluir(int $id): bool {
        $this->listarPorId($id);
        
        return $this->livroRepository->excluir($id);

    }
}