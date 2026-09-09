<?php

namespace App\Modules\Assuntos\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    protected $fillable = ['descricao'];
    protected $table = 'assunto';
}
