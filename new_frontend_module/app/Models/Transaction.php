<?php

namespace App\Models;

use App\Enums\TransferType;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Transaction extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['day'];

    protected $casts = [
        'type' => TxnType::class,
        'status' => TxnStatus::class,
        'pay_amount' => 'double',
        'amount' => 'double',
        'transfer_type' => TransferType::class,
    ];

    protected $searchable = [
        'amount',
        'tnx',
        'type',
        'method',
        'description',
        'status',
        'created_at',
    ];

    /*
     * Scope Declaration
     * */

    public function scopeStatus($query, $status)
    {
        if ($status && $status != 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeProfit($query)
    {
        return $query->whereIn('type', [TxnType::Referral, TxnType::SignupBonus, TxnType::PortfolioBonus, TxnType::RewardRedeem, TxnType::DpsMaturity, TxnType::FdrInstallment]);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('username', 'like', '%'.$search.'%');
                })->orWhere('tnx', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        return $query;
    }

    public function scopeType($query, $type)
    {
        if ($type && $type != 'all') {
            return $query->where('type', $type);
        }

        return $query;
    }

    public function scopeTransferType($query, $type)
    {
        if ($type && $type != 'all') {
            return $query->where('transfer_type', $type);
        }

        return $query;
    }

    public function scopeFundTransfar($query)
    {
        return $query->where('type', TxnType::FundTransfer->value);
    }

    public function scopePending($query)
    {
        return $query->where('status', TxnStatus::Pending->value);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', TxnStatus::Failed->value);
    }

    public function scopeOwnTransfer($query)
    {
        return $query->where('transfer_type', TransferType::OwnBankTransfer->value);
    }

    public function scopeOtherTransfer($query)
    {
        return $query->where('transfer_type', TransferType::OtherBankTransfer->value);
    }

    public function scopeWireTransfer($query)
    {
        return $query->where('transfer_type', TransferType::WireTransfer->value);
    }

    public function toSearchableArray(): array
    {
        return [
            'amount' => $this->amount,
            'tnx' => $this->tnx,
            'type' => $this->type,
            'method' => $this->method,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y h:i A');
    }

    public function getDayAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M');
    }

    public function scopeTnx($query, $tnx)
    {
        return $query->where('tnx', $tnx)->first();
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiery_id');
    }

    public function referral()
    {
        return $this->referrals()->where('type', '=', $this->target_type);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referral_target_id', 'target_id')->where('type', '=', $this->target_type);
    }

    public function level()
    {
        return $this->belongsTo(LevelReferral::class, 'target_id', 'the_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function profit_from_user()
    {
        return $this->belongsTo(User::class, 'profit_from');
    }

    public function totalDeposit()
    {
        return $this->where('status', TxnStatus::Success)->whereIn('type', [TxnType::Deposit, TxnType::ManualDeposit]);
    }

    public function totalWithdraw()
    {
        return $this->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('type', TxnType::Withdraw)
                ->orWhere('type', TxnType::WithdrawAuto);
        });
    }

    public function totalProfit()
    {
        return $this->where('status', TxnStatus::Success)->where(function ($query) {
            $query->whereIn('type', [TxnType::Referral, TxnType::SignupBonus, TxnType::PortfolioBonus, TxnType::RewardRedeem, TxnType::DpsMaturity, TxnType::FdrInstallment]);
        });
    }

    public function totalDepositBonus()
    {
        return $this->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('target_id', '!=', null)
                ->where('target_type', 'deposit')
                ->where('type', TxnType::Referral);
        })->sum('amount');
    }

    protected function method(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
        );
    }
}
