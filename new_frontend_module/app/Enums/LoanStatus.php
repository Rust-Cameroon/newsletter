<?php

namespace App\Enums;

enum LoanStatus: string
{
    case Due = 'due';
    case Running = 'running';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case Reviewing = 'reviewing';
    case Rejected = 'rejected';
}
