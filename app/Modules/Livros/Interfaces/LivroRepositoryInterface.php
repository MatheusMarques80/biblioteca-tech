<?php

namespace App\Modules\Livros\Interfaces;

use App\Modules\Autores\Models\Autor;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Livros\Models\Livro;

interface LivroRepositoryInterface {
 public function todos(): Collection;
 public function buscarPorId(int $id): ?Livro;
 public function criar(array $dados): Livro;
 public function atualizar(Livro $livro, array $dados): Livro;
 public function excluir(int $id): bool;
 public function cadastrarAutores(Livro $livro, array $autorIds): void;
 public function cadastrarAssuntos(Livro $livro, array $assuntos): void;
}