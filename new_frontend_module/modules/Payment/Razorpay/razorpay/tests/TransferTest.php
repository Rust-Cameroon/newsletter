<?php

namespace Razorpay\Tests;

class TransferTest extends TestCase
{
    /**
     * Specify unique transfer id, account id & payment id
     * for example trf_IEn4KYFgfD7q3F, acc_HjVXbtpSCIxENR &
     * pay_I7watngocuEY4P
     */
    private $transferId = 'trf_JtBI1uAaDdKkpJ';

    private $accountId = 'acc_HjVXbtpSCIxENR';

    private $paymentId = 'pay_LdarHRbodWJeXO';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Direct transfers
     */
    public function testDirectTransfer()
    {
        $data = $this->api->transfer->create(['account' => $this->accountId, 'amount' => 500, 'currency' => 'INR']);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('collection', $data->toArray()));
    }

    /**
     * Create transfers from payment
     */
    public function testCreateTransferPayment()
    {
        $data = $this->api->payment->fetch($this->paymentId)->transfer(['transfers' => [['account' => $this->accountId, 'amount' => '100', 'currency' => 'INR', 'notes' => ['name' => 'Gaurav Kumar', 'roll_no' => 'IEC2011025'], 'linked_account_notes' => ['branch'], 'on_hold' => '1', 'on_hold_until' => '1671222870']]]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('collection', $data->toArray()));

    }

    /**
     * Create transfers from order
     */
    public function testCreateTransferOrder()
    {
        $data = $this->api->order->create(['amount' => 100, 'currency' => 'INR', 'transfers' => [['account' => $this->accountId, 'amount' => 100, 'currency' => 'INR', 'notes' => ['branch' => 'Acme Corp Bangalore North', 'name' => 'Gaurav Kumar'], 'linked_account_notes' => ['branch'], 'on_hold' => 1, 'on_hold_until' => 1671222870]]]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('transfer', $data->toArray()));
    }

    /**
     * Fetch transfer for a payment
     */
    public function testFetchTransferPayment()
    {
        $data = $this->api->payment->fetch($this->paymentId)->transfers();

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('collection', $data->toArray()));
    }

    /**
     * Fetch transfer for an order
     */
    public function testFetchTransferOrder()
    {
        $order = $this->api->order->all();

        if ($order['count'] !== 0) {

            $data = $this->api->order->fetch($order['items'][0]['id'])->transfers(['expand[]' => 'transfers']);

            $this->assertTrue(is_array($data->toArray()));

            $this->assertTrue(in_array('order', $data->toArray()));
        }
    }

    /**
     * Fetch transfer
     */
    public function testFetchTransfer()
    {

        $data = $this->api->transfer->fetch($this->transferId);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('order', $data->toArray()));
    }

    /**
     * Fetch transfers for a settlement
     */
    public function testFetchSettlement()
    {
        $settlement = $this->api->transfer->all(['expand[]' => 'recipient_settlement']);

        if ($settlement['count'] !== 0) {

            $data = $this->api->transfer->all(['recipient_settlement_id' => $settlement['items'][0]['recipient_settlement_id']]);

            $this->assertTrue(is_array($data->toArray()));

        }
    }

    /**
     * Fetch settlement details
     */
    public function testFetchSettlementDetails()
    {
        $data = $this->api->transfer->all(['expand[]' => 'recipient_settlement']);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('collection', $data->toArray()));

    }

    /**
     * Refund payments and reverse transfer from a linked account
     */
    public function testRefundPayment()
    {
        $data = $this->api->payment->fetch($this->paymentId)->refund(['amount' => '100']);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('refund', $data->toArray()));
    }

    /**
     * Fetch payments of a linked account
     */
    public function testFetchPaymentsLinkedAccounts()
    {
        $data = $this->api->payment->fetch($this->paymentId)->refund(['amount' => '100']);

        $this->assertTrue(is_array($data->toArray()));
    }

    /**
     * Reverse transfers from all linked accounts
     */
    public function testReverseLinkedAccount()
    {
        $transfer = $this->api->transfer->create(['account' => $this->accountId, 'amount' => 100, 'currency' => 'INR']);

        $data = $this->api->transfer->fetch($transfer->id)->reverse(['amount' => 100]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('refund', $data->toArray()));
    }

    /**
     * Hold settlements for transfers
     */
    public function testHoldSettlements()
    {
        $data = $this->api->payment->fetch($this->paymentId)->transfer(['transfers' => [['account' => $this->accountId, 'amount' => '100', 'currency' => 'INR', 'on_hold' => '1']]]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('collection', $data->toArray()));
    }

    /**
     * Modify settlement hold for transfers
     */
    public function testModifySettlements()
    {
        $data = $this->api->transfer->fetch($this->transferId)->edit(['on_hold' => 1]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('transfer', $data->toArray()));
    }
}
