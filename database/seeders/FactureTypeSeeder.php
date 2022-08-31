<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FactureType;

class FactureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FactureType::create([
            'nom' => 'Proforma',
            'code' => 'proforma',
        ]);
        
        FactureType::create([
            'nom' => 'Définitive',
            'code' => 'definitive'
        ]);
        
        FactureType::create([
            'nom' => 'Avoir',
            'code' => 'avoir'
        ]);
    }
}
