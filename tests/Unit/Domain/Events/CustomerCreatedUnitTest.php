<?php

namespace Tests\Unit\Domain\Events;

use App\Domain\Events\CustomerCreated;
use Tests\TestCase;

class CustomerCreatedUnitTest extends TestCase
{
    public function testCustomerCreatedInstanceMustFillCustomerId(): void
    {
        $fakeCustomerCreated = new CustomerCreated(1);

        $this->assertEquals(1, $fakeCustomerCreated->customerId);
    }
}
