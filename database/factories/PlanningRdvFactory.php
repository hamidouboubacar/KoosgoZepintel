<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanningRdvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "date" => $this->faker->date(),
            "commercial_id" => User::all()->random()->id,
            "client_id" => Client::all()->random()->id
        ];
    }
}
