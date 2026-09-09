<x-layout>
    @if(isset($erro))
        <x-alerta-erro mensagem="{{ $erro }}"/>
    @else
        <x-alerta-erro mensagem="Ocorreu um erro na comunicação com o banco de dados."/>
    @endif
</x-layout>