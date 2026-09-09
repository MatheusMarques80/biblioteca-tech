<?php

namespace App\Modules\Relatorios\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Relatorios\Services\RelatorioAutorLivroService;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioAutorLivroController extends Controller
{

    public function __construct(private RelatorioAutorLivroService $relatorioAutorLivroService)
    {
    }

    public function gerar()
    {
        $autores_livros = $this->relatorioAutorLivroService->gerar();
        $pdf = Pdf::loadView('relatorios.autor_livros', compact('autores_livros'));
        return $pdf->stream();
    }
 }
