<x-layout>
    <x-modelo-card-consulta
        titulo="{{isset($livro->id) ? 'Editar Livro' : 'Cadastrar Livro'}}"
        subTitulo="{{isset($livro->id) ? 'Editar informações do livro' : 'Formulário para cadastro de um livro'}}"
        corBotao="btn-outline-secondary"
        rotaBotao="{{ request('inicio') == 1 ? route('inicio') : route('livros.index') }}">
        @slot('nomeAcaoBtn')
            <i class='bi bi-slash-circle'></i> Cancelar
        @endslot
        <form method="POST" action="{{isset($livro->id) ? route('livros.update', ['id' => $livro->id]) : route('livros.store')}}">
            @csrf
            @if(isset($livro->id)) 
                @method('PUT') 
            @endif
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input 
                    type="text" 
                    class="form-control @error('titulo') is-invalid @enderror" 
                    id="titulo" 
                    name="titulo" 
                    aria-describedby="tituloFeedback"  
                    value="{{old('titulo', $livro->titulo ?? '')}}"
                    placeholder="Informe o título do livro"
                    autocomplete="off"
                    maxlength="40"
                    required
                >
                @error('titulo')<div id="tituloFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="editora" class="form-label">Editora</label>
                <input 
                    type="text" 
                    class="form-control @error('editora') is-invalid @enderror" 
                    id="editora" 
                    name="editora" 
                    aria-describedby="editoraFeedback"  
                    value="{{old('editora', $livro->editora ?? '')}}"
                    placeholder="Informe a editora do livro"
                    autocomplete="off"
                    maxlength="40"
                    required
                >
                @error('editora')<div id="editoraFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="edicao" class="form-label">Edição</label>
                <input 
                    type="number" 
                    max="{{date('Y')}}"
                    class="form-control @error('edicao') is-invalid @enderror" 
                    id="edicao" 
                    name="edicao" 
                    aria-describedby="edicaoFeedback"  
                    value="{{old('edicao', $livro->edicao ?? '')}}"
                    placeholder="Informe a edição do livro"
                    autocomplete="off"
                    required
                >
                @error('edicao')<div id="edicaoFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="anoPublicacao" class="form-label">Ano de Publicação</label>
                <input 
                    type="number" 
                    class="form-control @error('ano_publicacao') is-invalid @enderror" 
                    id="ano_publicacao" 
                    name="ano_publicacao" 
                    aria-describedby="anoPublicacaoFeedback"  
                    value="{{old('ano_publicacao', $livro->ano_publicacao ?? '')}}"
                    placeholder="Informe o ano de publicação do livro"
                    autocomplete="off"
                    required
                >
                @error('ano_publicacao')<div id="anoPublicacaoFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor(R$)</label>
                <input 
                    type="text" 
                    class="form-control @error('valor') is-invalid @enderror" 
                    id="valor" 
                    name="valor" 
                    aria-describedby="valorFeedback"  
                    value="{{old('valor', $livro->valor ?? '')}}"
                    placeholder="Informe o valor do livro"
                    autocomplete="off"
                    required
                >
                @error('valor')<div id="valorFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="autores" class="form-label">Autor(es)</label>
                <div class="row">
                    @if(count($autores) > 0)
                        @foreach($autores as $autor)
                        <div class="col col-lg-4 mb-4">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    value="{{$autor->id}}"  
                                    name="autores[]" 
                                    id="checkAutor{{$autor->id}}"
                                    @checked(in_array($autor->id, old('autores', isset($livro) ? $livro->autores->pluck('id')->all() : [])))
                                >
                                <label class="form-check-label" for="checkAutor{{$autor->id}}">
                                    {{$autor->nome}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col col-lg-12">
                            <div class="alert alert-info">
                                Nenhum autor cadastrado
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <label for="assuntos" class="form-label">Assunto(s)</label>
                <div class="row">
                    @if(count($assuntos) > 0)
                        @foreach($assuntos as $assunto)
                            <div class="col col-lg-4 mb-4">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        value="{{$assunto->id}}"  
                                        name="assuntos[]" 
                                        id="checkAssunto{{$assunto->id}}"
                                        @checked(in_array($assunto->id, old('assuntos', isset($livro) ? $livro->assuntos->pluck('id')->all() : [])))
                                    >
                                    <label class="form-check-label" for="checkAssunto{{$assunto->id}}">
                                        {{$assunto->descricao}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col col-lg-12">
                            <div class="alert alert-info">
                                Nenhum assunto cadastrado
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm ms-auto">
                {{isset($livro->id) ? 'Salvar' : 'Cadastrar'}}
            </button>
        </form>
    </x-modelo-card-consulta>
    @slot('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.8.1/autoNumeric.min.js"></script>
        <script>
            const valor = new AutoNumeric('#valor', {
                currencySimbol: '',
                decimalCharacter: ',',
                digitGroupSeparator: '.',
                decimalPlaces: 2,
                unformatOnSubmit: true
            })
        </script>
    @endslot
</x-layout>