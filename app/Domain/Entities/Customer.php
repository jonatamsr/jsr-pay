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

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj ?? null;
    }

    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCustomerTypeId(): ?int
    {
        return $this->customer_type_id ?? null;
    }

    public function setCustomerTypeId(int $customerTypeId): void
    {
        $this->customer_type_id = $customerTypeId;
    }
}
