<?php

namespace App\Modules\Autores\Models;

use App\Modules\Livros\Models\Livro;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $fillable = ['nome'];
    protected $table = 'autor';

    public function livros () {
        return $this->belongsToMany(Livro::class);
    }
}
