<x-layout>
    <x-modelo-card-consulta 
        titulo="Assuntos" 
        subTitulo="Consulta de todos os assuntos cadastrados"
        corBotao="btn-outline-primary"
        rotaBotao="{{route('assuntos.create')}}"
    >
        @slot('nomeAcaoBtn')
            <i class='bi bi-person-circle'></i> Novo Assunto
        @endslot


        @if(session('sucesso'))
            <x-alerta-sucesso mensagem="{{session('sucesso')}}"></x-alerta-sucesso>
        @endif

        

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Descrição</th>
                    <th width="10%" class="text-end">Ações</th>
                </tr>
                @if(count($assuntos) > 0)
                    @foreach($assuntos as $assunto)
                        <tr>
                            <td>{{$assunto->descricao}}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a 
                                        class="btn btn-sm btn-warning" 
                                        href="{{route('assuntos.edit', ['id' => $assunto->id])}}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        data-bs-title="Editar Assunto"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form 
                                        method="POST" 
                                        action="{{route('assuntos.delete', ['id' => $assunto->id])}}"
                                        onsubmit="return confirm('Deseja realmente excluir este assunto?\n\n'
                                        +'O vinculo com o livro que este assunto está associado será excluído.\n\nOK = Confirmar exclusão\nCancelar = Não realizar exclusão')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top" 
                                            data-bs-title="Excluir Assunto"
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
                        <td colspan="2" class="text-center">Nenhum assunto cadastrado</td>
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