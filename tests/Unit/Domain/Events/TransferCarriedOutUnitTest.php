<?php

namespace Tests\Unit\Domain\Events;

use App\Domain\Events\TransferCarriedOut;
use Tests\TestCase;

class TransferCarriedOutUnitTest extends TestCase
{
    public function testTransferCarriedOutInstanceMustFillCustomerPayeeId(): void
    {
        $fakeEvent = new TransferCarriedOut(1);

        $this->assertEquals(1, $fakeEvent->payeeCustomerId);
    }
}
