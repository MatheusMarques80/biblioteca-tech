<?php

namespace App\Modules\Assuntos\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Assuntos\Models\Assunto;

interface AssuntoRepositoryInterface {
 public function todos(): Collection;
 public function buscarPorId(int $id): ?Assunto;
 public function criar(array $dados): Assunto;
 public function atualizar(Assunto $assunto, array $dados): Assunto;
 public function excluir(int $id): bool;
}