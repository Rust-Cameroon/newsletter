<?php

namespace App\Enums;

enum ReferralType: string
{
    case Deposit = 'deposit';
    case DPS = 'dps';
    case FDR = 'fdr';
    case Loan = 'loan';
    case PayBill = 'pay_bill';
}
