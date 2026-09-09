<x-layout>
    <x-modelo-card-consulta 
        titulo="Livros" 
        subTitulo="Consulta de todos os livros cadastrados"
        corBotao="btn-outline-primary"
        rotaBotao="{{route('livros.create')}}"
    >
        @slot('nomeAcaoBtn')
            <i class='bi bi-person-circle'></i> Novo Livro
        @endslot


        @if(session('sucesso'))
            <x-alerta-sucesso mensagem="{{session('sucesso')}}"></x-alerta-sucesso>
        @endif

        

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Título</th>
                    <th>Editora</th>
                    <th class="text-end">Edição</th>
                    <th class="text-end">Ano de Publicação</th>
                    <th>Autor(es)</th>
                    <th>Valor (R$)</th>
                    <th width="10%" class="text-end">Ações</th>
                </tr>
                @if(count($livros) > 0)
                    @foreach($livros as $livro)
                        <tr>
                            <td>{{$livro->titulo}}</td>
                            <td>{{$livro->editora}}</td>
                            <td class="text-end">{{$livro->edicao}}</td>
                            <td class="text-end">{{$livro->ano_publicacao}}</td>
                            <td>
                                {{ implode(", ", $livro->autores->pluck('nome')->all()) }}
                            </td>
                            <td class="text-end">{{number_format($livro->valor, 2, ',', '.')}}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a 
                                        class="btn btn-sm btn-warning" 
                                        href="{{route('livros.edit', ['id' => $livro->id])}}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        data-bs-title="Editar Livro"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form 
                                        method="POST" 
                                        action="{{route('livros.delete', ['id' => $livro->id])}}"
                                        onsubmit="return confirm('Deseja realmente excluir este livro?\n\n'
                                        +'Está operação não tem como ser revertida caso seja confirmada\n\nOK = Confirmar exclusão\nCancelar = Não realizar exclusão')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            class="btn btn-sm btn-danger" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top" 
                                            data-bs-title="Excluir Livro"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">Nenhum livro cadastrado</td>
                    </tr>
                @endif
            </table>
        </div>
    </x-modelo-card-consulta>
    @slot('scripts')
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    @endslot
</x-layout>