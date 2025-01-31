<?php

namespace App\Enums;

enum TxnStatus: string
{
    case Success = 'success';
    case Pending = 'pending';
    case Failed = 'failed';
}
