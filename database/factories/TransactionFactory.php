<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            "amount" => $this->faker->numberBetween(0,100000000),
            "type" => $this->faker->numberBetween(1,3),
            "webservice_id" => $this->faker->numberBetween(1,10)
        ];
    }
}
