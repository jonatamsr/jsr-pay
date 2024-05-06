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

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }
}
