<?php

namespace App\Enums;

enum TransferType: string
{
    case WireTransfer = 'wire_transfer';
    case OtherBankTransfer = 'other_bank_transfer';

    case OwnBankTransfer = 'own_bank_transfer';
}
