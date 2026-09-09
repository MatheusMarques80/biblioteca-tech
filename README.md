# Biblioteca Tech

- Projeto visa o cadastro, edição, listagem e exclusão de: Livros, assuntos e autores, com um relatório exibindo as informações das três entidades.

## Tecnologias e bibliotecas utilizadas

- Laravel Framework 13.30.1
- Autonumeric 4.8.1
- bootstrap 5.3.8
- barryvdh/laravel-dompdf
- mysql 9.7.2
- PHP 8.5.10
- PHPUnit
- Docker

## Arquitetura adotada

- Foi aplicado o SOLID com o conceito de SRP(Principio de responsabilidade unica) e DIP(Principio de Inversão de Dependencias). 
  Para atender essa arquitetura foram criadas as seguintes pastas dentro de Modules: 
    * Entidade: Dominio onde cada entidade (Livro, Autor, Assunto e Relatórios) tem sua própria pasta.
    * Controllers: Responsável por orquestrar os serviços e dar um retorno ao usuário
    * Services: Responsável por toda regra de negócio
    * Interfaces: Funciona como um contrato que determina o que meu repository deve implementar.
    * Repositories: Tudo referente à ações no meu banco de dados: Insert, Select, update e delete.
    * Models: Arquivo que referencia tabelas e views e suas colunas no banco de dados.

## Montando o ambiente de desenvolvimento

- Para levantar o ambiente de desenvolvimento será necessário ter o docker instalado e configurado, feito isso, basta seguir os passos abaixo:
    * Na raiz do projeto existe um arquivo chamado `.env.example`, com base nele crie um novo arquivo também na raiz do projeto com o nome de `.env`, altere o valor das variáveis: DB_USERNAME, DB_PASSWORD, DB_ROOT_PASSWORD de acordo com sua preferência.

    * Na raiz do projeto existe um arquivo chamado `.env.testing.example`, com base nele crie um novo arquivo também na raiz do projeto com o nome de `.env.testing`, coloque o valor das variáveis: DB_USERNAME, DB_PASSWORD igual ao que foi informado no arquivo `.env`.

    * Dê permissão ao script de criação da base de dados de testes `chmod +x docker/mysql/init/criarBancoTesteFeature.sh`, sem essa permissão irá ocorrer erros no momento de inicializar o container referente ao mysql.

    * Execute o comando `docker compose up -d --build`, ele irá levantar o ambiente e instalar as dependências. 
    *Atenção*: Caso esteja executando algum outro projeto em docker se certifique que as portas utilizadas neste projeto, não estejam sendo utilizadas por alguma outra aplicação em execução na sua máquina. Caso isso ocorra será necessário fazer a alteração nos arquivos Dockerfile ou docker-compose.yml

    * Após a execução do comando acima verifique através do comando `docker ps` se as imagens do nginx, biblioteca-app e mysql estão em execução.

    * Com as imagens em execução, execute os comandos abaixo: 
        ```
        docker compose exec app composer install
        docker compose exec app php artisan key:generate
        docker compose exec app php artisan key:generate --env=testing
        docker compose exec app php artisan migrate
        ```

- Feito os passos acima você terá acesso à aplicação através da seguinte url `http://localhost:8000`, caso tenha alterado a porta basta trocar a porta 8000 pela qual você informou no arquivo docker-compose.yml no serviço `nginx`.

## Rodando os testes da aplicação

- Para executar os testes da aplicação basta executar o seguinte comando `docker compose exec app ./vendor/bin/phpunit --coverage-text` isso irá mostrar a cobertura atual no seu terminal.