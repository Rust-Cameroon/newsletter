<?php

namespace App\Enums;

enum BillStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Return = 'return';
}
