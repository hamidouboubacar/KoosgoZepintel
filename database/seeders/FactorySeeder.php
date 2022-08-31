<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\PlanningRdv;
use App\Models\Document;
use App\Models\Paiement;
use App\Models\Package;
use App\Models\DocumentPackage;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();
        Client::factory()->count(50)->create();
        PlanningRdv::factory()->count(150)->create();
        Document::factory()->count(150)->create();
        Paiement::factory()->count(150)->create();
        Package::factory()->count(10)->create();
        DocumentPackage::factory()->count(200)->create();
    }
}
