<?php

namespace App\Modules\Autores\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Autores\Services\AutorService;
use Illuminate\Http\Request;

class AutorController extends Controller
{

    public function __construct(private AutorService $autorService)
    {
    }

    public function index(Request $request)
    {
        $autores = $this->autorService->listarTodos();

        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.formulario');
    }

    public function edit(int $id)
    {
        $autor = $this->autorService->listarPorId($id);

        return view('autores.formulario', compact('autor'));
    }

    public function store(Request $request)
    {
        $dados = $this->validarDados($request);
        $this->autorService->cadastrar($dados);

        return redirect()->route('autores.index')->with('sucesso', 'Autor cadastrado com sucesso');

    }

    public function update(Request $request, int $id)
    {
        $dados = $this->validarDados($request);
        $this->autorService->atualizar($dados, $id);

        return redirect()->route('autores.index')->with('sucesso', 'Autor atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        $this->autorService->excluir($id);
        return redirect()->route('autores.index')->with('sucesso', 'Autor excluído com sucesso');
    }

    private function validarDados (Request $request, ?int $id = null) {
        return $request->validate([
            'nome' => 'required|string|max:40'
        ], [
            'nome.required' => 'Nome é um campo obrigatório',
            'nome.max' => 'Nome deve ter no máximo 40 caracteres'
        ]);
    }
 }
