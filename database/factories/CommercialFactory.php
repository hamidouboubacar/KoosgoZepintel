<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommercialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->email,
            "password" => Hash::make("Admin123456."),
            "fonction_id" => Fonction::where("name", "LIKE", "Commercial%")->first()->id
        ];
    }
}
