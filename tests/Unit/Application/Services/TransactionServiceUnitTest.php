<?php

namespace Tests\Unit\Application\Services;
use App\Application\Services\TransactionService;
use App\Domain\Entities\Customer;
use App\Domain\Entities\Wallet;
use App\Domain\Events\TransferCarriedOut;
use App\Domain\Services\ValidateTransferService;
use App\Dtos\TransferDto;
use App\Models\TransactionStatus;
use App\Ports\Outbound\AuthorizationServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use App\Ports\Outbound\TransactionRepositoryPort;
use App\Ports\Outbound\WalletRepositoryPort;
use Exception;
use Illuminate\Events\Dispatcher;
use Tests\TestCase;

class TransactionServiceUnitTest extends TestCase
{
    private $transferValidatorMock;
    private $customerRepositoryPortMock;
    private $transactionRepositoryPortMock;
    private $authorizationServicePortMock;
    private $walletRepositoryPortMock;
    private $dispatcherMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transferValidatorMock = $this->createMock(ValidateTransferService::class);
        $this->app->instance(ValidateTransferService::class, $this->transferValidatorMock);

        $this->customerRepositoryPortMock = $this->createMock(CustomerRepositoryPort::class);
        $this->app->instance(CustomerRepositoryPort::class, $this->customerRepositoryPortMock);

        $this->transactionRepositoryPortMock = $this->createMock(TransactionRepositoryPort::class);
        $this->app->instance(TransactionRepositoryPort::class, $this->transactionRepositoryPortMock);

        $this->authorizationServicePortMock = $this->createMock(AuthorizationServicePort::class);
        $this->app->instance(AuthorizationServicePort::class, $this->authorizationServicePortMock);

        $this->walletRepositoryPortMock = $this->createMock(WalletRepositoryPort::class);
        $this->app->instance(WalletRepositoryPort::class, $this->walletRepositoryPortMock);

        $this->dispatcherMock = $this->createMock(Dispatcher::class);
        $this->app->instance(Dispatcher::class, $this->dispatcherMock);
    }

    public function testTransferMustCallEveryStepAndDispatchTransferCarriedOutEvent(): void
    {
        $fakePayerCustomerId = 1;
        $fakePayeeCustomerId = 2;
        $fakeAmount = 10.00;

        $fakeTransferData = [
            'payer' => $fakePayerCustomerId,
            'payee' => $fakePayeeCustomerId,
            'value' => $fakeAmount,
        ];

        $this->transferValidatorMock->expects($this->once())
            ->method('validateAmount')
            ->with($fakeAmount);

        $fakePayerCustomer = new Customer([
            'id' => $fakePayerCustomerId,
            'name' => 'fake-payer',
        ]);

        $fakePayeeCustomer = new Customer([
            'id' => $fakePayeeCustomerId,
            'name' => 'fake-payee',
        ]);

        $fakePayerWallet = new Wallet([
            'customer_id' => $fakePayerCustomerId,
            'balance' => 50,
        ]);

        $fakePayeeWallet = new Wallet([
            'customer_id' => $fakePayeeCustomerId,
            'balance' => 100,
        ]);

        $this->customerRepositoryPortMock->expects($this->exactly(2))
            ->method('getCustomerById')
            ->with(self::callback(self::consecutiveCalls($fakePayerCustomerId, $fakePayeeCustomerId)))
            ->willReturnOnConsecutiveCalls($fakePayerCustomer,$fakePayeeCustomer);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayer')
            ->with($fakePayerCustomer);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayee')
            ->with($fakePayeeCustomer);

        $this->customerRepositoryPortMock->expects($this->exactly(2))
            ->method('getCustomerWallet')
            ->with(self::callback(self::consecutiveCalls($fakePayerCustomerId, $fakePayeeCustomerId)))
            ->willReturnOnConsecutiveCalls($fakePayerWallet, $fakePayeeWallet);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayerWallet')
            ->with($fakeAmount, $fakePayerWallet);

        $fakeTransactionId = 500;
        $expectedTransferDto = new TransferDto($fakePayerCustomerId, $fakePayeeCustomerId, $fakeAmount);
        $this->transactionRepositoryPortMock->expects($this->once())
            ->method('createTransaction')
            ->with($expectedTransferDto)
            ->willReturn($fakeTransactionId);

        $this->authorizationServicePortMock->expects($this->once())
            ->method('authorize');

        $this->walletRepositoryPortMock->expects($this->exactly(2))
            ->method('updateBalance')
            ->with(
                self::callback(self::consecutiveCalls($fakePayerCustomerId, $fakePayeeCustomerId)),
                self::callback(self::consecutiveCalls((float) 40, (float) 110))
            );

        $this->dispatcherMock->expects($this->once())
            ->method('dispatch')
            ->with(self::callback(fn (TransferCarriedOut $event) => $event->payeeCustomerId == $fakePayeeCustomerId));

        $this->transactionRepositoryPortMock->expects($this->once())
            ->method('updateTransactionStatus')
            ->with($fakeTransactionId, TransactionStatus::STATUS_ID_SUCCESS);

        /** @var TransactionService */
        $service = app(TransactionService::class);
        $service->transfer($fakeTransferData);
    }

    public function testTransferMustUpdateTransactionWithErrorStatusWhenAnExceptionIsThrown(): void
    {
        $fakePayerCustomerId = 1;
        $fakePayeeCustomerId = 2;
        $fakeAmount = 10.00;

        $fakeTransferData = [
            'payer' => $fakePayerCustomerId,
            'payee' => $fakePayeeCustomerId,
            'value' => $fakeAmount,
        ];

        $this->transferValidatorMock->expects($this->once())
            ->method('validateAmount')
            ->with($fakeAmount);

        $fakePayerCustomer = new Customer([
            'id' => $fakePayerCustomerId,
            'name' => 'fake-payer',
        ]);

        $fakePayeeCustomer = new Customer([
            'id' => $fakePayeeCustomerId,
            'name' => 'fake-payee',
        ]);

        $fakePayerWallet = new Wallet([
            'customer_id' => $fakePayerCustomerId,
            'balance' => 50,
        ]);

        $fakePayeeWallet = new Wallet([
            'customer_id' => $fakePayeeCustomerId,
            'balance' => 100,
        ]);

        $this->customerRepositoryPortMock->expects($this->exactly(2))
            ->method('getCustomerById')
            ->with(self::callback(self::consecutiveCalls($fakePayerCustomerId, $fakePayeeCustomerId)))
            ->willReturnOnConsecutiveCalls($fakePayerCustomer,$fakePayeeCustomer);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayer')
            ->with($fakePayerCustomer);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayee')
            ->with($fakePayeeCustomer);

        $this->customerRepositoryPortMock->expects($this->exactly(2))
            ->method('getCustomerWallet')
            ->with(self::callback(self::consecutiveCalls($fakePayerCustomerId, $fakePayeeCustomerId)))
            ->willReturnOnConsecutiveCalls($fakePayerWallet, $fakePayeeWallet);

        $this->transferValidatorMock->expects($this->once())
            ->method('validatePayerWallet')
            ->with($fakeAmount, $fakePayerWallet);

        $fakeTransactionId = 500;
        $expectedTransferDto = new TransferDto($fakePayerCustomerId, $fakePayeeCustomerId, $fakeAmount);
        $this->transactionRepositoryPortMock->expects($this->once())
            ->method('createTransaction')
            ->with($expectedTransferDto)
            ->willReturn($fakeTransactionId);

        $this->authorizationServicePortMock->expects($this->once())
            ->method('authorize')
            ->willThrowException(new Exception('fake-exception'));
        $this->expectException(Exception::class);

        $this->walletRepositoryPortMock->expects($this->never())
            ->method('updateBalance');

        $this->dispatcherMock->expects($this->never())
            ->method('dispatch');

        $this->transactionRepositoryPortMock->expects($this->once())
            ->method('updateTransactionStatus')
            ->with($fakeTransactionId, TransactionStatus::STATUS_ID_ERROR);

        /** @var TransactionService */
        $service = app(TransactionService::class);
        $service->transfer($fakeTransferData);
    }

    public function testTransferMustUpdateTransactionWithErrorStatusWhenAnExceptionIsThrown2(): void
    {
        $fakePayerCustomerId = 1;
        $fakePayeeCustomerId = 2;
        $fakeAmount = 10.00;

        $fakeTransferData = [
            'payer' => $fakePayerCustomerId,
            'payee' => $fakePayeeCustomerId,
            'value' => $fakeAmount,
        ];

        $this->transferValidatorMock->expects($this->once())
            ->method('validateAmount')
            ->with($fakeAmount);

        $this->customerRepositoryPortMock->expects($this->once())
            ->method('getCustomerById')
            ->willThrowException(new Exception('fake-exception'));
            
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('fake-exception');

        /** @var TransactionService */
        $service = app(TransactionService::class);
        $service->transfer($fakeTransferData);
    }
}
