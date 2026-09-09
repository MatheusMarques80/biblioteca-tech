<?php

namespace App\Modules\Autores\Services;

use App\Modules\Autores\Interfaces\AutorRepositoryInterface;
use App\Modules\Autores\Models\Autor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AutorService {

    public function __construct(private AutorRepositoryInterface $autorRepository)
    {
    }

    public function listarTodos (): Collection {
        $autores = $this->autorRepository->todos();
        return $autores;
    }

    public function listarPorId (int $id): Autor {
        $autor = $this->autorRepository->buscarPorId($id);

        if (!isset($autor)) {
            throw new ModelNotFoundException('Autor não encontrado');
        }

        return $autor;
    }

    public function atualizar(array $dados, int $id): Autor {

        $autor = $this->listarPorId($id);

        return $this->autorRepository->atualizar($autor, $dados);

    }

    public function cadastrar(array $dados): Autor {

        $autores = $this->autorRepository->criar($dados);
        return $autores;

    }

    public function excluir(int $id): bool {
        $this->listarPorId($id);
        
        return $this->autorRepository->excluir($id);

    }
}