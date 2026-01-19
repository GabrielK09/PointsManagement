<?php

namespace App\Enum\Goal;

enum GoalTypes: string
{
    case PULLED = 'pulled';
    case CALLED = 'called';
    case WHATSAPP = 'whatsApp';
    case INDICATE = 'indicate';
    case XREMOTE = 'xremote';
    case CHAT = 'chat';
}
