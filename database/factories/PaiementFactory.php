<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $document = Document::all()->random();
        $montant_payer = $this->faker->numberBetween(1, $document->montantttc);
        $reste = $document->montantttc - $montant_payer;
        return [
            'montant_payer' => $montant_payer,
            'reste' => $reste,
            'user_id' => User::all()->random()->id,
            'document_id' => $document->id,
            'date' => $this->faker->date()
        ];
    }
}
