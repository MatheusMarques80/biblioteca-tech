<?php

namespace Tests\Unit;

use App\Modules\Assuntos\Interfaces\AssuntoRepositoryInterface;
use App\Modules\Assuntos\Models\Assunto;
use App\Modules\Assuntos\Services\AssuntoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class AssuntoTest extends TestCase
{
    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }

    public function test_assunto_listar_todos(): void {
        $dados = new Collection([new Assunto(['id' => 1, 'descricao' => 'Programação'])]);

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('todos')->once()->with()->andReturn($dados);

        $autorService = new AssuntoService($assuntoRepository);
        $this->assertSame($dados, $autorService->listarTodos());
    }

    public function test_assunto_listar_por_id_registro_nao_encontrado(): void {

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn(null);

        $autorService = new AssuntoService($assuntoRepository);

        $this->expectException(ModelNotFoundException::class);

        $autorService->listarPorId(1);

    }

    public function test_assunto_listar_por_id_registro_encontrado(): void {

        $dados = new Assunto(['id' => 1, 'descricao' => 'Programação']);

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dados);

        $autorService = new AssuntoService($assuntoRepository);

        $this->assertSame($dados, $autorService->listarPorId(1));

    }

    public function test_assunto_cadastrar(): void {
        $dados = new Assunto(['descricao' => 'Programação']);

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('criar')->once()->with(['descricao' => 'Programação'])->andReturn($dados);

        $assuntoService = new AssuntoService($assuntoRepository);

        $this->assertSame($dados, $assuntoService->cadastrar(['descricao' => 'Programação']));
    }

    public function test_assunto_atualizar_registro_nao_encontrado(): void {
        $dados = new Assunto(['id' => 1, 'descricao' => 'Programação']);
        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $assuntoRepository->shouldReceive('atualizar');

        $autorService = new AssuntoService($assuntoRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $autorService->atualizar(['descricao' => 'Analise de Dados'], 2));

    }

    public function test_assunto_atualizar_registro_encontrado (): void {
        $dadosAntigo = new Assunto(['id' => 1, 'descricao' => 'Programação']);
        $dadosNovo = new Assunto(['descricao' => 'Analise de Dados']);

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosAntigo);
        $assuntoRepository->shouldReceive('atualizar')->once()->with($dadosAntigo, ['descricao' => 'Analise de Dados'])->andReturn($dadosNovo);

        $autorService = new AssuntoService($assuntoRepository);
        
        $this->assertSame($dadosNovo, $autorService->atualizar(['descricao' => 'Analise de Dados'], 1));

    }

    public function test_assunto_excluir_registro_nao_encontrado(): void {

        $dados = true;

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $assuntoRepository->shouldReceive('excluir');

        $autorService = new AssuntoService($assuntoRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $autorService->excluir(2));

    }

    public function test_assunto_excluir_registro_encontrado(): void {

        $dadosAssunto = new Assunto(['id' => 1, 'descricao' => 'Programação']);
        $dados = true;

        $assuntoRepository = Mockery::mock(AssuntoRepositoryInterface::class);
        $assuntoRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosAssunto);
        $assuntoRepository->shouldReceive('excluir')->once()->with(1)->andReturn(true);

        $autorService = new AssuntoService($assuntoRepository);

        $this->assertSame($dados, $autorService->excluir(1));

    }
}
