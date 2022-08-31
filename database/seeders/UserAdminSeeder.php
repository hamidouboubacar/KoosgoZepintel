<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fonction;
use Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Fonction::where('name', 'Admin')->exists()) {
            Fonction::create([
                'name' => 'Admin',
                'code' => 'admin',
                'etat' => 1
            ]);
        }

        User::create([
            'name' => 'Admin',
            'email' => 'admin@netforce.com',
            'password' => Hash::make('Admin123456.'),
            'fonction_id' => Fonction::where('name', 'Admin')->first()->id
        ]);
    }
}
