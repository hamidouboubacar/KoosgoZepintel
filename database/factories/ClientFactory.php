<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Client;

class ClientFactory extends Factory
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
            "code_client" => $this->codeClient(),
            "user_id" => User::all()->random()->id,
            "type" => $this->faker->randomElement(['Client', 'Prospect'])
        ];
    }

    /**
     * get code client
     *
     * @return Str
     */
    private function codeClient() {
        $countClient = Client::where('type', 'Client')->count() + 1;
        $code_client = 'CL'.$countClient;
        return $code_client;
    }
}
