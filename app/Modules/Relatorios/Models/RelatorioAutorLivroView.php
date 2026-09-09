<?php

namespace App\Modules\Relatorios\Models;

use Illuminate\Database\Eloquent\Model;

class RelatorioAutorLivroView extends Model
{
    protected $table = 'vw_autor_livros';

    protected $casts = [
        'livros' => 'array'
    ];
}
