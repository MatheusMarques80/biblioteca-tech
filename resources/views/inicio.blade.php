<x-layout>
    <div class="row">
        <div class="col col-lg-6 mb-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-person-circle h4"></i> Cadastrar Autor</div>
                <div class="card-body text-center">
                    <a href="{{ route('autores.create', ['inicio' => 1]) }}" class="btn btn-outline-primary">Cadastrar um novo autor</a>
                </div>
            </div>
        </div>
        <div class="col col-lg-6 mb-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-tag h4"></i> Cadastrar Assunto</div>
                <div class="card-body text-center">
                    <a href="{{ route('assuntos.create', ['inicio' => 1]) }}" class="btn btn-outline-primary">Cadastrar um novo assunto</a>
                </div>
            </div>
        </div>
        <div class="col col-lg-6 mb-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-book h4"></i> Cadastrar Livro</div>
                <div class="card-body text-center">
                    <a href="{{ route('livros.create', ['inicio' => 1]) }}" class="btn btn-outline-primary">Cadastrar um novo livro</a>
                </div>
            </div>
        </div>

        <div class="col col-lg-6 mb-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-book h4"></i> Relatório dos autores e seus livros</div>
                <div class="card-body text-center">
                    <a href="{{ route('relatorio.autor_livros') }}" target="_blank" class="btn btn-outline-primary">Gerar</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>