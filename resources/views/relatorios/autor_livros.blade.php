<html>
    <head>
        <title>Relatório dos autores e seus livros</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"/>
    </head>
    <body>
        <div>
            <div>
                <h3 class="text-center">Biblioteca Tech</h3>
                <h4>Relatório dos autores e seus livros</h4>
                <p>Emitido em {{date('d/m/Y H:i:s')}}</p>
            </div>
            @if(count($autores_livros) > 0)
                @foreach ($autores_livros as $autor)
                    <fieldset class="margin-bt-3">
                        <legend>Autor: {{ $autor->nome}}</legend>
                        <table border="1" class="table">
                            <tr>
                                <th>Título</th>
                                <th>Editora</th>
                                <th class="text-end">Edição</th>
                                <th class="text-end">Assunto(s)</th>
                                <th class="text-end">Ano de Publicação</th>
                                <th class="text-end">Valor (R$)</th>
                            </tr>
                                @if(count($autor->livros) > 0)
                                    @foreach($autor->livros as $livro)
                                        <tr>
                                            <td>{{ $livro['titulo'] }}</td>
                                            <td>{{ $livro['editora'] }}</td>
                                            <td class="text-end">{{ $livro['edicao'] }}</td>
                                            <td>{{implode(", ", $livro['assuntos'])}}</td>
                                            <td class="text-end">{{ $livro['ano_publicacao'] }}</td>
                                            <td class="text-end">{{ number_format($livro['valor'], 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">Nenhum livro encontrado para este autor</td>
                                    </tr>
                                @endif
                        </table>
                    </fieldset>
                @endforeach
            @else
                <p id="nenhumRegistro" class="text-center"><b>Nenhum registro encontrado</b></p>
            @endif
        </div>
    </body>
</html>
<style>
    .table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        margin-top: 3%
    }
    .text-center {
        text-align: center;
    }

    .text-end {
        text-align: right;
    }

    .margin-bt-3 {
        margin-bottom: 4%
    }

    #nenhumRegistro {
        margin-top: 20%;
    }
</style>