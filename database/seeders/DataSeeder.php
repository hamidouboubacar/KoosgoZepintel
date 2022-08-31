<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fonction;
use App\Models\Client;
use App\Models\Document;
use App\Models\Paiement;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fonction::create([
            "name" => "Administrateur"
        ]);

        Fonction::create([
            "name" => "Commercial"
        ]);
        
        Fonction::create([
            "name" => "Client"
        ]);

        Fonction::create([
            "name" => "API"
        ]);

        $user = User::create([
            "name" => "Admin",
            "email" => "admin@netforce.com",
            "password" => Hash::make("Admin123456."),
            "fonction_id" => Fonction::where("name", "Administrateur")->first()->id
        ]);

        $user_test = User::create([
            "name" => "Admin Test",
            "email" => "admintest@netforce.com",
            "password" => Hash::make("KDAHjsadJGSJAsh"),
            "fonction_id" => Fonction::where("name", "Administrateur")->first()->id
        ]);
        
        // $user_commercial = User::create([
        //     "name" => "Commercial",
        //     "email" => "commercial@netforce.com",
        //     "password" => Hash::make("Commercial123456."),
        //     "fonction_id" => Fonction::where("name", "Commercial")->first()->id
        // ]);

        $paiement_user = User::create([
            "name" => "Paiement SMS",
            "email" => "paiement@netforce.com",
            "password" => Hash::make("JjM58Uy9WTd4i962yxmtp6LUZHP3d5"),
            "fonction_id" => Fonction::where("name", "API")->first()->id,
            "api_token" => "RihSh24wuU87ngqbzm867S9Y6UYwt2F97p5m4AtyVJAk9GvjX6p3AgMsr54RMTTZe8437UWxgT4827AD"
        ]);
        
        // $client = Client::create([
        //     "name" => "Client Test",
        //     "code_client" => "code_test",
        //     "user_id" => $user->id,
        //     // "user_client_id" => $client_user->id,
        //     "type" => "Client"
        // ]);

        // $client_user = User::create([
        //     "name" => "Client Test",
        //     "email" => "client@netforce.com",
        //     "password" => Hash::make("Client123456."),
        //     "client_id" => $client->id,
        //     "api_token" => Str::random(80),
        //     "fonction_id" => Fonction::where("name", "Client")->first()->id
        // ]);
        
        // $document = Document::create([
        //     "client_id" => $client->id,
        //     "type" => "Facture",
        //     "user_id" => $user->id,
        //     "numero" => "F0004/2022/4/4/ClientTest/1",
        //     "objet" => "Objet Test 1",
        //     "montantht" => 50000,
        //     "montantttc" => 50000,
        //     "date" => "2022-03-14",
        //     "reference" => "reference_test_1"
        // ]);
        
        // $document2 = Document::create([
        //     "client_id" => $client->id,
        //     "type" => "Facture",
        //     "user_id" => $user->id,
        //     "numero" => "F0004/2022/4/4/ClientTest/2",
        //     "objet" => "Objet Test 2",
        //     "montantht" => 60000,
        //     "montantttc" => 60000,
        //     "date" => "2022-03-14",
        //     "reference" => "reference_test_2"
        // ]);
        
        // Document::create([
        //     "client_id" => $client->id,
        //     "type" => "Facture",
        //     "user_id" => $user->id,
        //     "numero" => "F0004/2022/4/4/ClientTest/3",
        //     "objet" => "Objet Test 3",
        //     "montantht" => 70000,
        //     "montantttc" => 70000,
        //     "date" => "2022-03-14",
        //     "reference" => "reference_test_3"
        // ]);

        // Paiement::create([
        //     'date' => Carbon::now()->toDateString(),
        //     'date_paiement' => Carbon::now()->toDateString(),
        //     'mode_paiement' => 'OrangeMoney',
        //     'montant_payer' => $document->montantttc,
        //     'user_id' => $user->id,
        //     'document_id' => $document->id,
        //     'etat' => 1
        // ]);

        // Paiement::create([
        //     'date' => Carbon::now()->toDateString(),
        //     'date_paiement' => Carbon::now()->toDateString(),
        //     'mode_paiement' => 'OrangeMoney',
        //     'montant_payer' => $document2->montantttc / 2,
        //     'user_id' => $user->id,
        //     'document_id' => $document2->id,
        //     'etat' => 1
        // ]);
    }
}
