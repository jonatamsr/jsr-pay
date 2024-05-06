<?php

namespace App\Domain\Entities;

class Customer extends Entity
{
    protected ?int $id = null;
    protected int $customer_type_id;
    protected string $name;
    protected string $email;
    protected ?string $cpf = null;
    protected ?string $cnpj = null;
    protected string $password;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->password ?? null;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCpf(): ?string
    {
        return $this->cpf ?? null;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj ?? null;
    }

    public function getType(): ?int
    {
        return $this->customer_type_id ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function getCustomerTypeId(): ?string
    {
        return $this->customer_type_id ?? null;
    }
}
