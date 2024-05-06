<?php

namespace App\Domain\Entities;

class Transaction extends Entity
{
    protected ?int $id = null;
    protected int $payer_id;
    protected int $payee_id;
    protected int $transaction_status_id;
    protected float $amount;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getPayerId(): ?string
    {
        return $this->payer_id ?? null;
    }

    public function setPayerId(int $payerId): void
    {
        $this->payer_id = $payerId;
    }

    public function getPayeeId(): ?float
    {
        return $this->payee_id ?? null;
    }

    public function setPayeeId(float $payeeId): void
    {
        $this->payee_id = $payeeId;
    }

    public function getTransactionStatusId(): ?int
    {
        return $this->transaction_status_id ?? null;
    }

    public function setTransactionStatusId(float $transactionStatusId): void
    {
        $this->transaction_status_id = $transactionStatusId;
    }

    public function getAmount(): ?float
    {
        return $this->amount ?? null;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
}
