<?php

namespace App\Domain\Entities;

class Wallet extends Entity
{
    protected ?int $id = null;
    protected int $customer_id;
    protected float $balance;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomerId(): ?string
    {
        return $this->customer_id ?? null;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customer_id = $customerId;
    }

    public function getBalance(): ?float
    {
        return $this->balance ?? null;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}
