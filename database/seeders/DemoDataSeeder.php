<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Klanten
        $klant1 = \App\Models\Klant::create([
            'name' => 'Jan Janssen',
            'email' => 'jan@example.com',
            'phone' => '0612345678',
            'address' => 'Hoofdstraat 1, Amsterdam'
        ]);

        $klant2 = \App\Models\Klant::create([
            'name' => 'Maria de Boer',
            'email' => 'maria@example.com',
            'phone' => '0687654321',
            'address' => 'Kerkweg 5, Utrecht'
        ]);

        // Reizen
        $reis1 = \App\Models\Reis::create([
            'title' => 'Zonnig Spanje',
            'description' => 'Een heerlijke vakantie naar de Costa del Sol.',
            'price' => 850.00,
            'start_date' => '2026-07-01',
            'end_date' => '2026-07-15'
        ]);

        $reis2 = \App\Models\Reis::create([
            'title' => 'Avontuurlijk IJsland',
            'description' => 'Ontdek de geisers en watervallen van IJsland.',
            'price' => 1250.00,
            'start_date' => '2026-08-10',
            'end_date' => '2026-08-20'
        ]);

        // Accommodaties
        $acc1 = \App\Models\Accommodatie::create([
            'name' => 'Hotel Sun & Beach',
            'location' => 'Marbella, Spanje',
            'type' => 'Hotel',
            'price_per_night' => 120.00
        ]);

        $acc2 = \App\Models\Accommodatie::create([
            'name' => 'Camping Arctic Circle',
            'location' => 'Reykjavik, IJsland',
            'type' => 'Camping',
            'price_per_night' => 45.00
        ]);

        // Boekingen
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'jayavandepol@hotmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->update(['role' => 'admin']);
        }

        \App\Models\Boeking::create([
            'user_id' => $admin->id,
            'klant_id' => $klant1->id,
            'reis_id' => $reis1->id,
            'accommodatie_id' => $acc1->id,
            'booking_date' => now(),
            'status' => 'confirmed'
        ]);
    }
}
