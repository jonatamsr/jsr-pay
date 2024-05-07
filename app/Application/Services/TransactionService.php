<?php

namespace App\Application\Services;

use App\Domain\Events\TransferCarriedOut;
use App\Domain\Services\ValidateTransferService;
use App\Dtos\TransferDto;
use App\Models\TransactionStatus;
use App\Ports\Inbound\TransactionServicePort;
use App\Ports\Outbound\AuthorizationServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use App\Ports\Outbound\TransactionRepositoryPort;
use App\Ports\Outbound\WalletRepositoryPort;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionService implements TransactionServicePort
{
    public function __construct(
        private CustomerRepositoryPort $customerRepository,
        private WalletRepositoryPort $walletRepository,
        private AuthorizationServicePort $authorizationService,
        private TransactionRepositoryPort $transactionRepository,
        private ValidateTransferService $transferValidator,
        private Dispatcher $dispatcher
    ) {
        $this->customerRepository = $customerRepository;
        $this->walletRepository = $walletRepository;
        $this->authorizationService = $authorizationService;
        $this->transactionRepository = $transactionRepository;
        $this->transferValidator = $transferValidator;
        $this->dispatcher = $dispatcher;
    }

    public function transfer(array $transferData): void
    {
        try {
            $trasferDto = new TransferDto(
                Arr::get($transferData, 'payer'),
                Arr::get($transferData, 'payee'),
                Arr::get($transferData, 'value')
            );

            $this->transferValidator->validateAmount($trasferDto->amount);

            $payer = $this->customerRepository->getCustomerById($trasferDto->payerId);
            $this->transferValidator->validatePayer($payer);

            $payee = $this->customerRepository->getCustomerById($trasferDto->payeeId);
            $this->transferValidator->validatePayee($payee);

            $payerWallet = $this->customerRepository->getCustomerWallet($payer->getId());
            $this->transferValidator->validatePayerWallet($trasferDto->amount, $payerWallet);

            $transactionId = $this->transactionRepository->createTransaction($trasferDto);

            DB::beginTransaction();

            $newPayerBalance = $payerWallet->getBalance() - $trasferDto->amount;

            $payeeWallet = $this->customerRepository->getCustomerWallet($payee->getId());

            $newPayeeBalance = $payeeWallet->getBalance() + $trasferDto->amount;

            $this->authorizationService->authorize();

            $this->walletRepository->updateBalance($payer->getId(), $newPayerBalance);
            $this->walletRepository->updateBalance($payee->getId(), $newPayeeBalance);

            $this->dispatcher->dispatch(new TransferCarriedOut($payee->getId()));

            $this->transactionRepository->updateTransactionStatus(
                $transactionId,
                TransactionStatus::STATUS_ID_SUCCESS
            );

            DB::commit();
        } catch (Throwable $throwawble) {
            DB::rollBack();

            if (!isset($transactionId)) {
                throw $throwawble;
            }

            $this->transactionRepository->updateTransactionStatus(
                $transactionId,
                TransactionStatus::STATUS_ID_ERROR
            );

            throw $throwawble;
        }
    }
}
