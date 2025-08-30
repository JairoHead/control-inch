<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
            \App\Models\User::create([
            'name' => 'jairo dev',
            'email' => 'admin@inch.com',
            'password' => bcrypt('12345678'),
        ]);


        $this->call([
            DescargoSeeder::class,
            
            // Aquí puedes añadir otros seeders que tengas, como Clientes, Inspectores, etc.
            // ClienteSeeder::class,
            // InspectorSeeder::class,
        ]);
    }
}