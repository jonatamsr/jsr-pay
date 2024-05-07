<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $customerType = $this->faker->randomElement([1, 2]);
        if ($customerType === 1) {
            $document = [
                'customer_type_id' => $customerType,
                'cpf' => $this->faker->unique()->numerify('###########'),
            ];
        } else {
            $document = [
                'customer_type_id' => $customerType,
                'cnpj' => $this->faker->unique()->numerify('##############'),
            ];
        }
        return array_merge(
            $document,
            [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email,
                'password' => $this->faker->password,
            ]
        );
    }
}
