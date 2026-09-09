<?php

namespace App\Modules\Livros\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Assuntos\Services\AssuntoService;
use App\Modules\Autores\Services\AutorService;
use App\Modules\Livros\Services\LivroService;
use Illuminate\Http\Request;

class LivroController extends Controller
{

    public function __construct(private LivroService $livroService, private AutorService $autorService, private AssuntoService $assuntoService)
    {
    }

    public function index(Request $request)
    {
        // Execução do serviço para listar todos os livros
        $livros = $this->livroService->listarTodos();

        return view('livros.index', compact('livros'));
    }

    public function create()
    {
        // Carrega formulário de livros e executa os serviços de listagem para autores e assuntos para que seja possível a seleção dos checkbox.
        $autores = $this->autorService->listarTodos();
        $assuntos = $this->assuntoService->listarTodos();
        return view('livros.formulario', compact('autores', 'assuntos'));
    }

    public function edit(int $id)
    {

        // Carrega formulário para edição do livro
        $livro = $this->livroService->listarPorId($id);
        $autores = $this->autorService->listarTodos();
        $assuntos = $this->assuntoService->listarTodos();

        return view('livros.formulario', compact('livro', 'autores', 'assuntos'));
    }

    public function store(Request $request)
    {
        // Controller responsável pela efetivação do cadastro dos livros na base
        $autorIds = $request->input('autores', []);
        $assuntoIds = $request->input('assuntos', []);
        $dados = $this->validarDados($request);

        $this->livroService->cadastrar($dados, $autorIds, $assuntoIds);

        return redirect()->route('livros.index')->with('sucesso', 'Livro cadastrado com sucesso');

    }

    public function update(Request $request, int $id)
    {
        // Controller responsável pela efetivação de edição dos dados do livro
        $autorIds = $request->input('autores', []);
        $assuntoIds = $request->input('assuntos', []);
        $dados = $this->validarDados($request);
        $this->livroService->atualizar($dados, $autorIds, $assuntoIds, $id);

        return redirect()->route('livros.index')->with('sucesso', 'Livro atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        // Controller responsável pela exclusão do livro
        $this->livroService->excluir($id);
        return redirect()->route('livros.index')->with('sucesso', 'Livro excluído com sucesso');
    }

    private function validarDados (Request $request, ?int $id = null) {

        $ano_atual = date('Y');

        return $request->validate([
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'ano_publicacao' => 'required|string|max:4|lte:'.$ano_atual,
            'valor'          => 'required|numeric|decimal:0,2|min:0|max:99999999.99',
            ], [
            'titulo.required' => 'Título é um campo obrigatório',
            'titulo.max' => 'Título deve ter no máximo 40 caracteres',
            'editora.required' => 'Editora é um campo obrigatório',
            'editora.max' => 'Editora deve ter no máximo 40 caracteres',
            'edicao.required' => 'Edição é um campo obrigatório',
            'edicao.integer' => 'Edição deve ser um número',
            'edicao.min' => 'Edição deve ser um número maior que zero',
            'ano_publicacao.required' => 'Ano de Publicação é um campo obrigatório',
            'ano_publicacao.max' => 'Ano de Publicação deve ter no máximo 4 caracteres',
            'ano_publicacao.lte' => 'Ano de Publicação não pode ser maior que o atual('.$ano_atual.')',
            'valor.required' => 'Valor é um campo obrigatório',
            'valor.min' => 'Valor não pode ser um número negativo',
            'valor.max' => 'Valor máximo permitido é de 99999999.99'
        ]);
    }
 }
