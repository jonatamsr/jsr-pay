<?php

namespace Tests\Functional;

use App\Adapters\Inbound\Controllers\TransactionController;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class TransferFunctionalTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TransactionController $transactionController */
    private $transactionController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionController = app(TransactionController::class);
    }

    public function testCommonCustomerCreationFlow(): void
    {
        $fakePayer = Customer::factory()->create([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
        ]);
        $fakePayerWallet = Wallet::factory()->create(['customer_id' => $fakePayer->id]);

        $fakePayee = Customer::factory()->create([]);
        $fakePayeeWallet = Wallet::factory()->create(['customer_id' => $fakePayee->id]);

        $requestData = [
            'payer' => $fakePayer->id,
            'payee' => $fakePayee->id,
            'value' => 30,
        ];

        $request = Request::create('/customer','POST', $requestData);

        $this->transactionController->transfer($request);

        $fakePayerWallet->refresh();
        $this->assertEquals(970.0, $fakePayerWallet->balance);

        $fakePayeeWallet->refresh();
        $this->assertEquals(1030.0, $fakePayeeWallet->balance);
    }
}
