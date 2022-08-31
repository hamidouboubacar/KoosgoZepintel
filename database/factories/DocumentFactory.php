<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $client = Client::all()->random();
        $type = $this->faker->randomElement(['Devis', 'Facture']);
        $code = $this->genererCode($client, $type);
        $montantht = $this->faker->randomNumber();
        $tva = $montantht * 0.18;
        $montantttc = $montantht * 1.18;
        $total_versement = $this->faker->numberBetween(1, $montantttc);
        $reste_a_payer = $montantttc - $total_versement;
        return [
            'client_id' => $client->id,
            'type' => $type,
            'user_id' => User::all()->random()->id,
            'numero' => $code,
            'objet' => $this->faker->text(50),
            'montantht' => $montantht,
            'montantttc' => $montantttc,
            'total_versement' => $total_versement,
            'reste_a_payer' => $reste_a_payer,
            'tva' => $tva,
            'date' => $this->faker->date(),
            'reference' => $this->faker->text(50)
        ];
    }

    private function genererCode($client, $type) {
        $total_type = Document::where('type', $type)->count() + 1;
        if(isset($client) && $client != null)
            $total_client = Document::where('type', $type)->where('client_id', $client->id)->count() + 1;
        else $total_client = $total_type;
        
        if($total_type < 10) $prefix = '000';
        elseif($total_type < 100) $prefix = '00';
        elseif($total_type < 1000) $prefix = '0';
        else $prefix = '';
        
        if($type == 'Facture') $fp ='F';
        elseif($type == 'FactureAvoir') $fp = 'FA';
        else $fp ='FP';
        $name = isset($client) && $client != null && isset($client->name) ? str_replace(" ", "", $client->name) : 'client';
        
        $now = \Carbon\Carbon::now();
        $code = "$fp$prefix$total_type/$now->year/$now->month/$now->day/$name/$total_client";
        
        return $code;
    }
}
