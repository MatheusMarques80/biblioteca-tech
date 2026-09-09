<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Caso meu registro não seja encontrado
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

            if (!$e->getPrevious() instanceof ModelNotFoundException) {
                return null;
            }

            $mensagem = $e->getPrevious()->getMessage() ?: 'Registro não encontrado';

            if ($request->expectsJson()) {
                return response()->json(['mensagem' => $mensagem], 404);
            }

            return response()->view('erros.banco', ['erro' => $mensagem], 404);
        });

        // Erros de conexão, violação ou qualquer outro erro referente a banco de dados
        $exceptions->render(function (QueryException $e, Request $request) {
            $sql = $e->errorInfo[0] ?? null;

            $mensagem = match($sql) {
                '23000' => 'Violação de restrição detectada SQLSTATE: 23000.',
                '42S02' => 'Tabela ou view não encontrada',
                'HY000' => 'Ocorreu uma falha ao tentar se conectar com o banco de dados. SQLSTATE: HY000',
                default => 'Ocorreu uma falha ao tentar se conectar com o banco de dados'
            };

            report($e);

            if ($request->expectsJson()) {
                return response()->json(['mensagem' => $mensagem], 500);
            }

            if (config('app.debug')) {
                return null;
            }

            return response()->view('erros.banco', ['erro' => $mensagem], 500);
        });
    })->create();
