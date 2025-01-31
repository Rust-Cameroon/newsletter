<?php

namespace App\Facades\Txn;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\RewardTrait;
use Illuminate\Support\Facades\Auth;
use Remotelywork\Installer\Repository\App;
use Str;

class Txn
{
    use RewardTrait;

    /**
     * @param  null  $payCurrency
     * @param  null  $payAmount
     * @param  null  $userID
     * @param  null  $fromUserID
     * @param  string  $fromModel
     * @param  array  $manualDepositData
     */
    public function new($amount, $charge, $final_amount, $method, $description, string|TxnType $type, string|TxnStatus $status = TxnStatus::Pending, $payCurrency = null, $payAmount = null, $userID = null, $relatedUserID = null, $relatedModel = 'User', array $manualFieldData = [], string $approvalCause = 'none', $targetId = null, $targetType = null, $isLevel = false): Transaction
    {
        if ($type === 'withdraw') {
            self::withdrawBalance($amount);
        }

        $transaction = new Transaction();
        $transaction->user_id = $userID ?? Auth::user()->id;
        $transaction->from_user_id = $relatedUserID;
        $transaction->from_model = $relatedModel;
        $transaction->tnx = 'TRX'.strtoupper(Str::random(10));
        $transaction->description = $description;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->charge = $charge;
        $transaction->final_amount = $final_amount;
        $transaction->method = $method;
        $transaction->pay_currency = $payCurrency;
        $transaction->pay_amount = $payAmount;
        $transaction->manual_field_data = json_encode($manualFieldData);
        $transaction->approval_cause = $approvalCause;
        $transaction->target_id = $targetId;
        $transaction->target_type = $targetType;
        $transaction->is_level = $isLevel;
        $transaction->status = $status;
        $transaction->save();

        if ($transaction->status === TxnStatus::Success) {
            self::rewardToUser($transaction->user_id, $transaction->id);
        }

        return $transaction;
    }

    public static function transfer($amount, $charge, $final_amount, $description, string|TxnType $type, string|TxnStatus $status, $payCurrency, $payAmount, $userID, $relatedUserID, $relatedModel, $beneficiaryId, $purpose, $transferType, array $manualFieldData = [])
    {
        $transaction = new Transaction();
        $transaction->user_id = $userID ?? Auth::user()->id;
        $transaction->from_user_id = $relatedUserID;
        $transaction->from_model = $relatedModel;
        $transaction->tnx = 'TRX'.strtoupper(Str::random(10));
        $transaction->description = $description;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->charge = $charge;
        $transaction->final_amount = $final_amount;
        $transaction->pay_currency = $payCurrency;
        $transaction->pay_amount = $payAmount;
        $transaction->beneficiery_id = $beneficiaryId;
        $transaction->status = $status;
        $transaction->purpose = $purpose;
        $transaction->transfer_type = $transferType;
        $transaction->manual_field_data = json_encode($manualFieldData);
        $transaction->save();

        if ($transaction->status === TxnStatus::Success) {
            self::rewardToUser($transaction->user_id, $transaction->id);
        }

        return $transaction;
    }

    private function withdrawBalance($amount): void
    {
        User::find(auth()->user()->id)->removeMoney($amount);
    }

    public function update($tnx, $status, $userId = null, $approvalCause = 'none')
    {
        $transaction = Transaction::tnx($tnx);

        $uId = $userId == null ? auth()->user()->id : $userId;

        $user = User::find($uId);

        if ($status == TxnStatus::Success && App::initApp() && ($transaction->type == TxnType::Deposit || $transaction->type == TxnType::ManualDeposit)) {
            $amount = $transaction->amount;
            $user->increment('balance', $amount);
        }

        $data = [
            'status' => $status,
            'approval_cause' => $approvalCause,
        ];

        if ($status == TxnStatus::Success) {
            $this->rewardToUser($uId, $transaction->id);
        }

        $transaction = $transaction->update($data);

        return $transaction;

    }
}
