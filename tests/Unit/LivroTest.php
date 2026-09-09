<?php

namespace Tests\Unit;

use App\Modules\Livros\Interfaces\LivroRepositoryInterface;
use App\Modules\Livros\Models\Livro;
use App\Modules\Livros\Services\LivroService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;

class LivroTest extends TestCase
{
    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }

    public function test_livro_listar_todos(): void {
        $dados = new Collection([new Livro([
            'id' => 1, 
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ])]);

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('todos')->once()->with()->andReturn($dados);

        $livroService = new LivroService($livroRepository);
        $this->assertSame($dados, $livroService->listarTodos());
    }

    public function test_livro_listar_por_id_registro_nao_encontrado(): void {

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn(null);

        $livroService = new LivroService($livroRepository);

        $this->expectException(ModelNotFoundException::class);

        $livroService->listarPorId(1);

    }

    public function test_livro_listar_por_id_registro_encontrado(): void {

        $dados = new Livro([
            'id' => 1, 
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dados);

        $livroService = new LivroService($livroRepository);

        $this->assertSame($dados, $livroService->listarPorId(1));

    }

    public function test_livro_cadastrar(): void {
        $livro = new Livro([
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);

        DB::shouldReceive('transaction')->once()->andReturnUsing(fn (\Closure $callback) => $callback());

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('criar')->once()->andReturn($livro);
        $livroRepository->shouldReceive('cadastrarAutores')->once()->andReturn($livro, [1, 2]);
        $livroRepository->shouldReceive('cadastrarAssuntos')->once()->andReturn($livro, [1, 2, 3]);

        $livroService = new LivroService($livroRepository);

        $this->assertSame(
            $livro,
            $livroService->cadastrar(
                [
                    'titulo' => 'PHP',
                    'editora' => 'Livre',
                    'edicao' => 1,
                    'ano_publicacao' => 2026,
                    'valor' => 100.00
                ],
                [1, 2],
                [1, 2, 3]
            )
        );
    }

    public function test_livro_atualizar_registro_nao_encontrado(): void {
        $dados = new Livro([
            'id' => 1, 
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);
        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $livroRepository->shouldReceive('atualizar');

        $livroService = new LivroService($livroRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $livroService->atualizar(
            ['id' => 1, 'titulo' => 'PHP', 'editora' => 'Livre', 'edicao' => 1, 'ano_publicacao' => 2026, 'valor' => 100.00]
            ,[2, 4, 6]
            ,[2, 1, 6]
            ,2
        ));

    }

    public function test_livro_atualizar_registro_encontrado (): void {
        $dadosLivroAntigo = new Livro([
            'id' => 1,
            'titulo' => 'PHP',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);

        $dadosLivroNovo = new Livro([
            'titulo' => 'Node.js',
            'editora' => 'Livre',
            'edicao' => 1,
            'ano_publicacao' => 2026,
            'valor' => 100.00
        ]);
        

        DB::shouldReceive('transaction')->once()->andReturnUsing(fn (\Closure $callback) => $callback());

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosLivroAntigo);
        $livroRepository->shouldReceive('atualizar')->once()->andReturn($dadosLivroNovo);
        $livroRepository->shouldReceive('cadastrarAutores')->once()->andReturn($dadosLivroNovo, [1, 2]);
        $livroRepository->shouldReceive('cadastrarAssuntos')->once()->andReturn($dadosLivroNovo, [1, 2, 3]);

        $livroService = new LivroService($livroRepository);

        $this->assertSame(
            $dadosLivroAntigo,
            $livroService->atualizar(
                [
                    'titulo' => 'Node.js',
                    'editora' => 'Livre',
                    'edicao' => 1,
                    'ano_publicacao' => 2026,
                    'valor' => 100.00
                ],
                [1, 2],
                [1, 2, 3],
                1
            )
        );

    }

    public function test_livro_excluir_registro_nao_encontrado(): void {

        $dados = true;

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $livroRepository->shouldReceive('excluir');

        $livroService = new LivroService($livroRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $livroService->excluir(2));

    }

    public function test_livro_excluir_registro_encontrado(): void {

        $dadosLivro = new Livro(
            [
                'id' => 1,
                'titulo' => 'PHP',
                'editora' => 'Livre',
                'edicao' => 1,
                'ano_publicacao' => 2026,
                'valor' => 100.00
            ]
        );
        $dados = true;

        $livroRepository = Mockery::mock(LivroRepositoryInterface::class);
        $livroRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosLivro);
        $livroRepository->shouldReceive('excluir')->once()->with(1)->andReturn(true);

        $livroService = new LivroService($livroRepository);

        $this->assertSame($dados, $livroService->excluir(1));

    }
}
