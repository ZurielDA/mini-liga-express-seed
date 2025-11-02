<?php

namespace App\Enums;

enum POINTS: int
{
    case WON = 3;
    case DRAW = 1;
    case LOST = 0;
}
