<?php

namespace App\Enums;

enum KYCStatus: int
{
    case NOT_SUBMITTED = 0;
    case Verified = 1;
    case Pending = 2;
    case Failed = 3;
}
