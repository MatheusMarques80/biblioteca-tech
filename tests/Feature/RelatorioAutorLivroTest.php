<?php

namespace Tests\Feature;

use App\Modules\Assuntos\Models\Assunto;
use App\Modules\Autores\Models\Autor;
use App\Modules\Livros\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatorioAutorLivroTest extends TestCase
{
    use RefreshDatabase;

    public function test_relatorio_autor_livros(): void {
        $autor = Autor::create(['nome' => 'Matheus Marques']);
        $assunto = Assunto::create(['descricao' => 'Programação']);
        $livro = Livro::create([
            'id' => 1,
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);
        $livro->autores()->attach($autor->id);
        $livro->assuntos()->attach($assunto->id);

        $response = $this->get(route('relatorio.autor_livros'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
