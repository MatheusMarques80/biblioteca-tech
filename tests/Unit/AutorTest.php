<?php

namespace Tests\Unit;

use App\Modules\Autores\Interfaces\AutorRepositoryInterface;
use App\Modules\Autores\Models\Autor;
use App\Modules\Autores\Services\AutorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class AutorTest extends TestCase
{
    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }

    public function test_autor_listar_todos(): void {
        $dados = new Collection([new Autor(['nome' => 'Matheus Marques'])]);

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('todos')->once()->with()->andReturn($dados);

        $autorService = new AutorService($autorRepository);
        $this->assertSame($dados, $autorService->listarTodos());
    }

    public function test_autor_listar_por_id_registro_nao_encontrado(): void {

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn(null);

        $autorService = new AutorService($autorRepository);

        $this->expectException(ModelNotFoundException::class);

        $autorService->listarPorId(1);

    }

    public function test_autor_listar_por_id_registro_encontrado(): void {

        $dados = new Autor(['id' => 1, 'nome' => 'Matheus Marques']);

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dados);

        $autorService = new AutorService($autorRepository);

        $this->assertSame($dados, $autorService->listarPorId(1));

    }

    public function test_autor_atualizar_registro_nao_encontrado(): void {
        $dados = new Autor(['id' => 1, 'nome' => 'Matheus Marques']);
        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $autorRepository->shouldReceive('atualizar');

        $autorService = new AutorService($autorRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $autorService->atualizar(['nome' => 'Maria Marques'], 2));

    }

    public function teste_autor_cadastrar(): void {
        $dados = new Autor(['nome' => 'Matheus Marques']);

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('criar')->once()->with(['nome' => 'Matheus Marques'])->andReturn($dados);

        $autorService = new AutorService($autorRepository);

        $this->assertSame($dados, $autorService->cadastrar(['nome' => 'Matheus Marques']));
    }

    public function test_autor_atualizar_registro_encontrado (): void {
        $dadosAntigo = new Autor(['id' => 1, 'nome' => 'Matheus Marquess']);
        $dadosNovo = new Autor(['nome' => 'Matheus Marques']);

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosAntigo);
        $autorRepository->shouldReceive('atualizar')->once()->with($dadosAntigo, ['nome' => 'Matheus Marques'])->andReturn($dadosNovo);

        $autorService = new AutorService($autorRepository);
        
        $this->assertSame($dadosNovo, $autorService->atualizar(['nome' => 'Matheus Marques'], 1));

    }

    public function test_autor_excluir_registro_nao_encontrado(): void {

        $dados = true;

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(2)->andReturn(null);
        $autorRepository->shouldReceive('excluir');

        $autorService = new AutorService($autorRepository);

        $this->expectException(ModelNotFoundException::class);

        $this->assertSame($dados, $autorService->excluir(2));

    }

    public function test_autor_excluir_registro_encontrado(): void {

        $dadosAutor = new Autor(['id' => 1, 'nome' => 'Matheus Marques']);
        $dados = true;

        $autorRepository = Mockery::mock(AutorRepositoryInterface::class);
        $autorRepository->shouldReceive('buscarPorId')->once()->with(1)->andReturn($dadosAutor);
        $autorRepository->shouldReceive('excluir')->once()->with(1)->andReturn(true);

        $autorService = new AutorService($autorRepository);

        $this->assertSame($dados, $autorService->excluir(1));

    }
}
