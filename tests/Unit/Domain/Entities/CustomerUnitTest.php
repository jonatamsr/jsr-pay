<?php

namespace Tests\Unit\Domain\Entities;
use App\Domain\Entities\Customer;
use Tests\TestCase;

class CustomerUnitTest extends TestCase
{
    public function testNewCustomerWithoutDataMustIntantiateNullifiedEntity(): void
    {
        $fakeCustomer = new Customer([]);

        $expectedResult = [
            'id' => null,
            'customer_type_id' => null,
            'name' => null,
            'email' => null,
            'cpf' => null,
            'cnpj' => null,
            'password' => null,
        ];

        $this->assertEquals($expectedResult, $fakeCustomer->toArray());
    }

    public function testCustomerMustSetAndGetIdCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setId(1);

        $this->assertEquals(1, $fakeCustomer->getId());
    }

    public function testCustomerMustSetAndGetNameCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setName('fake-name');

        $this->assertEquals('fake-name', $fakeCustomer->getName());
    }

    public function testCustomerMustSetAndGetEmailCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setEmail('fake-email');

        $this->assertEquals('fake-email', $fakeCustomer->getEmail());
    }

    public function testCustomerMustSetAndGetCpfCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setCpf('12345678901');

        $this->assertEquals('12345678901', $fakeCustomer->getCpf());
    }

    public function testCustomerMustSetAndGetCnpjCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setCnpj('12345678901234');

        $this->assertEquals('12345678901234', $fakeCustomer->getCnpj());
    }

    public function testCustomerMustSetAndGetPasswordCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setPassword('fake-password');

        $this->assertEquals('fake-password', $fakeCustomer->getPassword());
    }

    public function testCustomerMustSetAndGetCustomerTypeIdCorrectly(): void
    {
        $fakeCustomer = new Customer([]);

        $fakeCustomer->setCustomerTypeId(1);

        $this->assertEquals(1, $fakeCustomer->getCustomerTypeId());
    }
}
