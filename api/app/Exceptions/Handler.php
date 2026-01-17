<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        Log::error('Erro detectado: ', [
            'erro' => $e
        ]);

        if($e instanceof \Illuminate\Auth\AuthenticationException)
        {
            return apiError(
                'Usuário não autenticado!',
                [],
                false,
                401
            );
        }

        if($e instanceof \App\Exceptions\User\TimeNotAssociatedWithTheUser)
        {
            return apiError(
                $e->getMessage(),
                [],
                false,
                $e->getStatusCode()
            );
        }

        if($e instanceof \Illuminate\Validation\UnauthorizedException)
        {
            return apiError(
                $e->getMessage(),
                [],
                false,
                403
            );
        }

        if($e instanceof \App\Exceptions\User\IncorrectCredentials)
        {
            return apiError(
                $e->getMessage(),
                [],
                false,
                404
            );
        }

        if($e instanceof \Illuminate\Validation\ValidationException)
        {
            return apiError(
                $e->getMessage(),
                $e->errors(),
                false,
                422
            );
        }

        if($e instanceof \App\Exceptions\Goal\GoalTypeNotFound)
        {
            return apiError(
                $e->getMessage(),
                [],
                false,
                404
            );
        }

        return apiError(
            'Erro interno.',
            [
                'error' => $e->getMessage()
            ],
            false,
            500
        );
    }
}
