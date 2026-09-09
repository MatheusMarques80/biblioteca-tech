<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_autor_livros as
            SELECT 
                aut.nome,
                (
                    SELECT 
                        COALESCE(JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'titulo', liv.titulo,
                                'edicao', liv.edicao,
                                'editora', liv.editora,
                                'ano_publicacao', liv.ano_publicacao,
                                'valor', liv.valor,
                                'assuntos', (
                                    SELECT COALESCE(JSON_ARRAYAGG(ass.descricao), JSON_ARRAY()) FROM livro_assunto lss
                                    INNER JOIN assunto ass ON lss.assunto_id = ass.id
                                    WHERE lss.livro_id = liv.id
                                )
                            )
                        ), JSON_ARRAY())
                    FROM livro_autor lau 
                    INNER JOIN livro liv ON lau.livro_id = liv.id
                    WHERE lau.autor_id = aut.id
                ) as livros
            FROM autor aut
            GROUP BY aut.id, aut.nome
            ORDER BY aut.nome
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_autor_livros");
    }
};
