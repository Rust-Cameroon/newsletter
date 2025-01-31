<?php

namespace App\Enums;

enum DpsStatus: string
{
    case Due = 'due';
    case Running = 'running';
    case Closed = 'closed';
    case Mature = 'mature';
}
