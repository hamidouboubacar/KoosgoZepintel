<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nom" => $this->faker->randomElement(['GOLD', 'OR', 'PLATIN', 'ARGENT', 'BRONZE', 'DIAMAND']),
            "debit_ascendant" => $this->faker->numberBetween(1, 25),
            "debit_descendant" => $this->faker->numberBetween(1, 25),
            "montant" => $this->faker->numberBetween(10000, 100000)
        ];
    }
}
