<?php

namespace App\Enums;

enum FdrStatus: string
{
    case Completed = 'completed';
    case Running = 'running';
    case Closed = 'closed';
}
