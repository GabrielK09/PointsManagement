<?php

namespace App\Enum\UseCase\UserGoal;

enum TypeGoalUpdate: string
{
    case PULLED = 'pulled';
    case CALLED = 'called';
    case WHATSAPP = 'whatsApp';
    case INDICATE = 'indicate';
    case XREMOTE = 'xremote';
    case CHAT = 'chat';

}