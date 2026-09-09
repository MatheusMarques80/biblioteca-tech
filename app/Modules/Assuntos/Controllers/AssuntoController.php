<?php

namespace App\Modules\Assuntos\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Assuntos\Services\AssuntoService;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{

    public function __construct(private AssuntoService $assuntoService)
    {
    }

    public function index()
    {
        $assuntos = $this->assuntoService->listarTodos();
        return view('assuntos.index', compact('assuntos'));
    }

    public function create()
    {
        return view('assuntos.formulario');
    }

    public function edit(int $id)
    {
        $assunto = $this->assuntoService->listarPorId($id);
        return view('assuntos.formulario', compact('assunto'));
    }

    public function store(Request $request)
    {
        $dados = $this->validarDados($request);
        $this->assuntoService->cadastrar($dados);

        return redirect()->route('assuntos.index')->with('sucesso', 'Assunto cadastrado com sucesso');

    }

    public function update(Request $request, int $id)
    {
        $dados = $this->validarDados($request);
        $this->assuntoService->atualizar($dados, $id);

        return redirect()->route('assuntos.index')->with('sucesso', 'Assunto atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        $this->assuntoService->excluir($id);
        return redirect()->route('assuntos.index')->with('sucesso', 'Assunto excluído com sucesso');
    }

    private function validarDados (Request $request, ?int $id = null) {
        return $request->validate([
            'descricao' => 'required|string|max:20'
        ], [
            'descricao.required' => 'Descrição é um campo obrigatório',
            'descricao.max' => 'Descrição deve ter no máximo 20 caracteres'
        ]);
    }
 }
