<?php

namespace App\Modules\Livros\Models;

use App\Modules\Assuntos\Models\Assunto;
use App\Modules\Autores\Models\Autor;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $fillable = ['titulo', 'editora', 'edicao', 'ano_publicacao', 'valor'];
    protected $table = 'livro';

    public function autores () {
        return $this->belongsToMany(Autor::class, 'livro_autor');
    }

    public function assuntos () {
        return $this->belongsToMany(Assunto::class, 'livro_assunto');
    }
}
