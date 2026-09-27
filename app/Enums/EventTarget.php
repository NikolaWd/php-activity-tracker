<?php

declare(strict_types=1);

namespace App\Enums;

enum EventTarget: string
{
    case PageA = 'page-a';
    case PageB = 'page-b';
    case BuyCow = 'buy-a-cow';
    case Download = 'download';
}
