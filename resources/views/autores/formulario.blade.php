<x-layout>
    <x-modelo-card-consulta
        titulo="{{isset($autor->id) ? 'Editar Autor' : 'Cadastrar Autor'}}"
        subTitulo="{{isset($autor->id) ? 'Editar informações do autor' : 'Formulário para cadastro de um autor'}}"
        corBotao="btn-outline-secondary"
        rotaBotao="{{ request('inicio') == 1 ? route('inicio') : route('autores.index') }}">
        @slot('nomeAcaoBtn')
            <i class='bi bi-slash-circle'></i> Cancelar
        @endslot

        <form method="POST" action="{{isset($autor->id) ?route('autores.update', ['id' => $autor->id]) : route('autores.store')}}">
            @csrf
            @if(isset($autor->id)) 
                @method('PUT') 
            @endif
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input 
                    type="text" 
                    class="form-control @error('nome') is-invalid @enderror" 
                    id="nome" 
                    name="nome" 
                    aria-describedby="nomeFeedback"  
                    value="{{old('nome', $autor->nome ?? '')}}"
                    placeholder="Informe o nome do autor"
                    autocomplete="off"
                    required
                >
                @error('nome')<div id="nomeFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm ms-auto">
                {{isset($autor->id) ? 'Salvar' : 'Cadastrar'}}
            </button>
        </form>
    </x-modelo-card-consulta>
</x-layout>