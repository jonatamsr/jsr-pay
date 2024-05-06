<?php

namespace Tests\Unit\Application\Services;
use App\Application\Services\CustomerService;
use App\Domain\Entities\Customer;
use App\Domain\Events\CustomerCreated;
use App\Domain\Services\ValidateCustomerCreationService;
use App\Models\CustomerType;
use App\Ports\Outbound\CustomerRepositoryPort;
use Illuminate\Events\Dispatcher;
use Tests\TestCase;

class CustomerServiceUnitTest extends TestCase
{
    private $customerRepositoryMock;
    private $customerValidatorMock;
    private $dispatcherMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerValidatorMock = $this->createMock(ValidateCustomerCreationService::class);
        $this->app->instance(ValidateCustomerCreationService::class, $this->customerValidatorMock);

        $this->customerRepositoryMock = $this->createMock(CustomerRepositoryPort::class);
        $this->app->instance(CustomerRepositoryPort::class, $this->customerRepositoryMock);

        $this->dispatcherMock = $this->createMock(Dispatcher::class);
        $this->app->instance(Dispatcher::class, $this->dispatcherMock);
    }

    public function testCustomerServiceMustCreateCustomerAndDispatchCustomerCreationEvent(): void
    {
        $fakeCustomerCreationData = [
            'name' => 'fake-customer',
            'email' => 'fake@customer.com',
            'password' => 'fake-password',
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '12345678901',
        ];
        $fakeCustomerId = 1;

        $this->customerValidatorMock->expects($this->once())->method('validate')->willReturn(true);

        $expectedEncryptedPassword = '49e7fe32454e3248d317d70a771bc95559df96115fe9a01faca5972e0475c1d6';

        $this->customerRepositoryMock->expects($this->once())
            ->method('createCustomer')
            ->with(
                self::callback(
                    fn (Customer $customer) =>
                        $customer->getName() == $fakeCustomerCreationData['name']
                        && $customer->getPassword() == $expectedEncryptedPassword
                        && $customer->getCustomerTypeId() === 1
                        && $customer->getCpf() == '12345678901'
                        && $customer->getEmail() == 'fake@customer.com'
                )
            )
            ->willReturn($fakeCustomerId);

        $this->dispatcherMock->expects($this->once())
            ->method('dispatch')
            ->with(self::callback(fn (CustomerCreated $customerCreated) => $customerCreated->customerId === $fakeCustomerId));

        /** @var CustomerService */
        $service = app(CustomerService::class);
        $service->createCustomer($fakeCustomerCreationData);
    }
}
