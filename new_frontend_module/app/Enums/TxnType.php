<?php

namespace App\Enums;

enum TxnType: string
{
    case Deposit = 'deposit';
    case Subtract = 'subtract';
    case ManualDeposit = 'manual_deposit';
    case SendMoney = 'send_money';
    case Exchange = 'exchange';
    case Referral = 'referral';
    case SignupBonus = 'signup_bonus';
    case PortfolioBonus = 'portfolio_bonus';
    case RewardRedeem = 'reward_redeem';
    case Withdraw = 'withdraw';
    case WithdrawAuto = 'withdraw_auto';
    case ReceiveMoney = 'receive_money';
    case Refund = 'refund';
    case FundTransfer = 'fund_transfer';
    case Loan = 'loan';
    case LoanApply = 'loan_applied';
    case LoanInstallment = 'loan_installment';
    case DpsInstallment = 'dps_installment';
    case DpsIncrease = 'dps_increase';
    case DpsDecrease = 'dps_decrease';
    case FdrIncrease = 'fdr_increase';
    case FdrDecrease = 'fdr_decrease';
    case DpsMaturity = 'dps_maturity';
    case DpsCancelled = 'dps_cancelled';
    case Fdr = 'fdr';
    case FdrInstallment = 'fdr_installment';
    case FdrMaturityFee = 'fdr_maturity_fee';
    case FdrCancelled = 'fdr_cancelled';
    case PayBill = 'pay_bill';
}
