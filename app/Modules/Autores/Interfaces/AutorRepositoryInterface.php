<?php

namespace App\Modules\Autores\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Autores\Models\Autor;

interface AutorRepositoryInterface {
 public function todos(): Collection;
 public function buscarPorId(int $id): ?Autor;
 public function criar(array $dados): Autor;
 public function atualizar(Autor $autor, array $dados): Autor;
 public function excluir(int $id): bool;
}