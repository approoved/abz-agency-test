<?php

namespace App\Models\UserPosition;

enum UserPositionName: string
{
    case Security = 'Security';

    case Designer = 'Designer';

    case ContentManager = 'Content Manager';

    case Lawyer = 'Lawyer';
}
