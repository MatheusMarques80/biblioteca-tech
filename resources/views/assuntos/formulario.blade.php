<x-layout>
    <x-modelo-card-consulta
        titulo="{{isset($assunto->id) ? 'Editar Assunto' : 'Cadastrar Assunto'}}"
        subTitulo="{{isset($assunto->id) ? 'Editar informações do assunto' : 'Formulário para cadastro de um assunto'}}"
        corBotao="btn-outline-secondary"
        rotaBotao="{{ request('inicio') == 1 ? route('inicio') : route('assuntos.index') }}">
        @slot('nomeAcaoBtn')
            <i class='bi bi-slash-circle'></i> Cancelar
        @endslot

        <form method="POST" action="{{isset($assunto->id) ?route('assuntos.update', ['id' => $assunto->id]) : route('assuntos.store')}}">
            @csrf
            @if(isset($assunto->id)) 
                @method('PUT') 
            @endif
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input 
                    type="text" 
                    class="form-control @error('descricao') is-invalid @enderror" 
                    id="descricao" 
                    name="descricao" 
                    aria-describedby="descricaoFeedback"  
                    value="{{old('descricao', $assunto->descricao ?? '')}}"
                    placeholder="Informe a descrição do assunto"
                    autocomplete="off"
                    required
                >
                @error('descricao')<div id="descricaoFeedback" class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm ms-auto">
                {{isset($assunto->id) ? 'Salvar' : 'Cadastrar'}}
            </button>
        </form>
    </x-modelo-card-consulta>
</x-layout>