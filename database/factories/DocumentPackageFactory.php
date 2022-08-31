<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;
use App\Models\Document;

class DocumentPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'package_id' => Package::all()->random()->id,
            'document_id' => Document::all()->random()->id,
            'quantite' => $this->faker->numberBetween(1, 10)
        ];
    }
}
