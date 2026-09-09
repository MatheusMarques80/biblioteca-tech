<?php

namespace App\Modules\Assuntos\Services;

use App\Modules\Assuntos\Interfaces\AssuntoRepositoryInterface;
use App\Modules\Assuntos\Models\Assunto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssuntoService {

    public function __construct(private AssuntoRepositoryInterface $assuntoRepository)
    {
    }

    public function listarTodos (): Collection {
        $assuntos = $this->assuntoRepository->todos();
        return $assuntos;
    }

    public function listarPorId (int $id): Assunto {
        $assunto = $this->assuntoRepository->buscarPorId($id);

        if (!isset($assunto)) {
            throw new ModelNotFoundException('Assunto não encontrado');
        }

        return $assunto;
    }

    public function atualizar(array $dados, int $id): Assunto {

        $assunto = $this->listarPorId($id);

        return $this->assuntoRepository->atualizar($assunto, $dados);

    }

    public function cadastrar(array $dados): Assunto {

        $assuntos = $this->assuntoRepository->criar($dados);
        return $assuntos;

    }

    public function excluir(int $id): bool {
        $this->listarPorId($id);
        
        return $this->assuntoRepository->excluir($id);

    }
}