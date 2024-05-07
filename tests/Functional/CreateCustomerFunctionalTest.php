<?php

namespace Tests\Functional;

use App\Adapters\Inbound\Controllers\CustomerController;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCustomerFunctionalTest extends TestCase
{
    use DatabaseTransactions;

    /** @var CustomerController $customerController */
    private $customerController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerController = app(CustomerController::class);
    }

    public function testCommonCustomerCreationFlow(): void
    {
        $requestData = [
            'name' => 'Fake Customer',
            'email' => 'fake@customer.com',
            'password' => 'fake-password',
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '12345678901',
            'cnpj' => null
        ];

        $request = Request::create('/customer', 'POST', $requestData);

        $response = $this->customerController->createCustomer($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('"Customer created successfully!"', $response->getContent());

        $customerFromDb = Customer::where('email', $requestData['email'])->first();

        $expectedHashedPassword = '49e7fe32454e3248d317d70a771bc95559df96115fe9a01faca5972e0475c1d6';

        $this->assertEquals('Fake Customer', $customerFromDb->name);
        $this->assertEquals('fake@customer.com', $customerFromDb->email);
        $this->assertEquals($expectedHashedPassword, $customerFromDb->password);
        $this->assertEquals(CustomerType::TYPE_ID_COMMON, $customerFromDb->customer_type_id);
        $this->assertEquals('12345678901', $customerFromDb->cpf);
        $this->assertNull($customerFromDb->cnpj);

        $customerWalletFromDb = Wallet::where('customer_id', $customerFromDb->id)->first();

        $this->assertNotNull($customerWalletFromDb);
        $this->assertEquals(0, $customerWalletFromDb->balance);
    }

    public function testRetailerCustomerCreationFlow(): void
    {
        $requestData = [
            'name' => 'Fake Company',
            'email' => 'fake@company.com',
            'password' => 'fake-password',
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cpf' => null,
            'cnpj' => '12345678901234'
        ];

        $request = Request::create('/customer', 'POST', $requestData);

        $response = $this->customerController->createCustomer($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('"Customer created successfully!"', $response->getContent());

        $customerFromDb = Customer::where('email', $requestData['email'])->first();

        $expectedHashedPassword = '49e7fe32454e3248d317d70a771bc95559df96115fe9a01faca5972e0475c1d6';

        $this->assertEquals('Fake Company', $customerFromDb->name);
        $this->assertEquals('fake@company.com', $customerFromDb->email);
        $this->assertEquals($expectedHashedPassword, $customerFromDb->password);
        $this->assertEquals(CustomerType::TYPE_ID_RETAILER, $customerFromDb->customer_type_id);
        $this->assertNull($customerFromDb->cpf);
        $this->assertEquals('12345678901234', $customerFromDb->cnpj);

        $customerWalletFromDb = Wallet::where('customer_id', $customerFromDb->id)->first();

        $this->assertNotNull($customerWalletFromDb);
        $this->assertEquals(0, $customerWalletFromDb->balance);
    }
}
