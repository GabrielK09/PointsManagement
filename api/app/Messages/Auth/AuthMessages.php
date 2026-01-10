<?php

namespace App\Messages\Auth;

enum AuthMessages: string
{
    case NAME_REQUIRED = 'O nome do usuário é obrigatório!';
    case NAME_FORMAT = 'O nome precisa estar em um formato válido!';
    case NAME_MAX = 'O nome precisa ter um máximo de 120 caracteres!';

    case EMAIL_REQUIRED = 'O e-mail do usuário é obrigatório!';
    case EMAIL_FORMAT = 'O e-mail precisa estar em um formato válido!';
    case EMAIL_UNIQUE = 'O e-mail informado já está cadastrado!';

    case PASSWORD_REQUIRED = 'A senha do usuário é obrigatório!';
    case PASSWORD_FORMAT = 'A senha do usuário precisa estar em um formato válido!';
    case PASSWORD_MAX = 'A senha do usuário precisa ter um máximo de 120 caracteres!';
    case PASSWORD_MIN = 'A senha do usuário precisa ter um minímo de 8 caracteres!';

    case TEAM_REQUIRED = 'O time do usuário é obrigatório!';
    case TEAM_FORMAT = 'O time do usuário precisa estar em um formato válido!';
    case TEAM_IN = 'O time do usuário precisa estar conter um desses valores Cinza, Azul, Verde, Vermelho, Roxo, Marrom, Laranja, Amarelo';
}