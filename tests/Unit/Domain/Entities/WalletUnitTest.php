<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Wallet;
use Tests\TestCase;

class WalletUnitTest extends TestCase
{
    public function testNewWalletWithoutDataMustIntantiateNullifiedEntity(): void
    {
        $fakeWallet = new Wallet([]);

        $expectedResult = [
            'id' => null,
            'customer_id' => null,
            'balance' => null,
        ];

        $this->assertEquals($expectedResult, $fakeWallet->toArray());
    }

    public function testWalletMustSetAndGetIdCorrectly(): void
    {
        $fakeWallet = new Wallet([]);

        $fakeWallet->setId(1);

        $this->assertEquals(1, $fakeWallet->getId());
    }

    public function testWalletMustSetAndGetCustomerIdCorrectly(): void
    {
        $fakeWallet = new Wallet([]);

        $fakeWallet->setCustomerId(2);

        $this->assertEquals(2, $fakeWallet->getCustomerId());
    }

    public function testWalletMustSetAndGetBalanceCorrectly(): void
    {
        $fakeWallet = new Wallet([]);

        $fakeWallet->setBalance(120.00);

        $this->assertEquals(120.00, $fakeWallet->getBalance());
    }
}
