<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Transaction;
use Tests\TestCase;

class TransactionUnitTest extends TestCase
{
    public function testNewTransactionWithoutDataMustIntantiateNullifiedEntity(): void
    {
        $fakeTransaction = new Transaction([]);

        $expectedResult = [
            'id' => null,
            'payer_id' => null,
            'payee_id' => null,
            'transaction_status_id' => null,
            'amount' => null,
        ];

        $this->assertEquals($expectedResult, $fakeTransaction->toArray());
    }

    public function testTransactionMustSetAndGetIdCorrectly(): void
    {
        $fakeTransaction = new Transaction([]);

        $fakeTransaction->setId(1);

        $this->assertEquals(1, $fakeTransaction->getId());
    }

    public function testTransactionMustSetAndGetPayerIdCorrectly(): void
    {
        $fakeTransaction = new Transaction([]);

        $fakeTransaction->setPayerId(2);

        $this->assertEquals(2, $fakeTransaction->getPayerId());
    }

    public function testTransactionMustSetAndGetPayeeIdCorrectly(): void
    {
        $fakeTransaction = new Transaction([]);

        $fakeTransaction->setPayeeId(3);

        $this->assertEquals(3, $fakeTransaction->getPayeeId());
    }

    public function testTransactionMustSetAndGetTransactionStatusIdCorrectly(): void
    {
        $fakeTransaction = new Transaction([]);

        $fakeTransaction->setTransactionStatusId(4);

        $this->assertEquals(4, $fakeTransaction->getTransactionStatusId());
    }

    public function testTransactionMustSetAndGetAmountCorrectly(): void
    {
        $fakeTransaction = new Transaction([]);

        $fakeTransaction->setAmount(120.00);

        $this->assertEquals(120.00, $fakeTransaction->getAmount());
    }
}
