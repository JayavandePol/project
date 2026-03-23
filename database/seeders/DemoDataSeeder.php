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
        $klant1 = \App\Models\Klant::firstOrCreate(
            ['email' => 'jan@example.com'],
            [
                'name' => 'Jan Janssen',
                'phone' => '0612345678',
                'address' => 'Hoofdstraat 1, Amsterdam'
            ]
        );

        $klant2 = \App\Models\Klant::firstOrCreate(
            ['email' => 'maria@example.com'],
            [
                'name' => 'Maria de Boer',
                'phone' => '0687654321',
                'address' => 'Kerkweg 5, Utrecht'
            ]
        );

        // Reizen
        $reis1 = \App\Models\Reis::firstOrCreate(
            ['title' => 'Zonnig Spanje'],
            [
                'description' => 'Een heerlijke vakantie naar de Costa del Sol.',
                'price' => 850.00,
                'start_date' => '2026-07-01',
                'end_date' => '2026-07-15'
            ]
        );

        $reis2 = \App\Models\Reis::firstOrCreate(
            ['title' => 'Avontuurlijk IJsland'],
            [
                'description' => 'Ontdek de geisers en watervallen van IJsland.',
                'price' => 1250.00,
                'start_date' => '2026-08-10',
                'end_date' => '2026-08-20'
            ]
        );

        // Accommodaties
        $acc1 = \App\Models\Accommodatie::firstOrCreate(
            ['name' => 'Hotel Sun & Beach'],
            [
                'location' => 'Marbella, Spanje',
                'type' => 'Hotel',
                'price_per_night' => 120.00
            ]
        );

        $acc2 = \App\Models\Accommodatie::firstOrCreate(
            ['name' => 'Camping Arctic Circle'],
            [
                'location' => 'Reykjavik, IJsland',
                'type' => 'Camping',
                'price_per_night' => 45.00
            ]
        );

        // Boekingen
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'jayavandepol@hotmail.com'],
            [
                'name' => 'JayavandePol',
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
