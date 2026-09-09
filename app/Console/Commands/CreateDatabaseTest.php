<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

#[Signature('db:criar-base-de-testes')]
#[Description('Cria o banco para a base de testes')]
class CreateDatabaseTest extends Command
{

    public function handle(): void 
    {
        try {
            $database = config('database.connections.mysql.database').'_teste';
            $usuario = config('database.connections.mysql.username');
            $host = config('database.connections.mysql.host');
            $porta = config('database.connections.mysql.port');
            $senha = env('DB_ROOT_PASSWORD');

            $pdoConnection = new PDO("mysql:host=".$host.";port=".$porta.";dbname=information_schema", 'root', $senha);
            $pdoConnection->exec("CREATE DATABASE IF NOT EXISTS ".$database);
            $pdoConnection->exec("GRANT ALL PRIVILEGES ON ".$database." * TO '".$usuario."'@'%'");
            $pdoConnection->exec("FLUSH PRIVILEGES");

            $pdoConnection = null;

            $this->info("Banco '".$database."' criado com sucesso para uso nos testes de feature.");
        } catch(\Exception $e) {
            $pdoConnection = null;
            $this->error("Não foi possível criar o banco. Mensagem Tec: ".$e->getMessage());
        }
        
    }
}
