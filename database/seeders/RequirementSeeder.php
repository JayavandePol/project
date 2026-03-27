<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klant;
use App\Models\Reis;
use App\Models\Accommodatie;
use App\Models\Boeking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RequirementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Zorg voor een Admin Gebruiker
        $admin = User::firstOrCreate(
            ['email' => 'admin@hoeve.nl'],
            [
                'name' => 'Admin Gebruiker',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ]
        );

        // 2. Klant aanmaken
        $klant = Klant::firstOrCreate(
            ['email' => 'tester@voorbeeld.nl'],
            [
                'name' => 'Test Gebruiker',
                'phone' => '0612345678',
                'address' => 'Teststraat 10, Teststad'
            ]
        );

        // 3. Reizen aanmaken
        $toekomstigeReis = Reis::firstOrCreate(
            ['title' => 'Toekomstige Droomreis'],
            [
                'destination' => 'Malediven',
                'description' => 'Een reis die pas over 6 maanden begint.',
                'price' => 2500.00,
                'max_participants' => 10,
                'start_date' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonths(6)->addDays(14)->format('Y-m-d')
            ]
        );

        $verledenReis = Reis::firstOrCreate(
            ['title' => 'Verleden Ervaring'],
            [
                'destination' => 'Rome',
                'description' => 'Deze reis is al lang geleden afgelopen.',
                'price' => 800.00,
                'max_participants' => 20,
                'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->subMonths(2)->addDays(7)->format('Y-m-d')
            ]
        );

        // 4. Accommodatie
        $acc = Accommodatie::firstOrCreate(
            ['name' => 'Requirement Resort'],
            [
                'location' => 'Malediven',
                'type' => 'Resort',
                'rating' => 5,
                'amenities' => 'Wifi, Pool, Beach',
                'price_per_night' => 200.00
            ]
        );

        // 5. Boekingen aanmaken (Direct via DB inserts om triggers/SPs te omzeilen indien nodig, of via Model)
        
        // --- SCENARIO 1: HAPPY (Toekomst, Onbetaald) ---
        $boekingHappy = Boeking::create([
            'user_id' => $admin->id,
            'klant_id' => $klant->id,
            'reis_id' => $toekomstigeReis->id,
            'accommodatie_id' => $acc->id,
            'num_people' => 2,
            'booking_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending'
        ]);
        \App\Models\Factuur::create([
            'boeking_id' => $boekingHappy->id,
            'invoice_number' => 'INV-HAPPY-' . $boekingHappy->id,
            'amount' => 5000.00,
            'due_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
            'status' => 'unpaid',
        ]);

        // --- SCENARIO 2: UNHAPPY (Betaald) ---
        $boekingPaid = Boeking::create([
            'user_id' => $admin->id,
            'klant_id' => $klant->id,
            'reis_id' => $toekomstigeReis->id,
            'accommodatie_id' => $acc->id,
            'num_people' => 4,
            'booking_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'confirmed'
        ]);
        \App\Models\Factuur::create([
            'boeking_id' => $boekingPaid->id,
            'invoice_number' => 'INV-PAID-' . $boekingPaid->id,
            'amount' => 10000.00,
            'due_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'status' => 'paid',
        ]);

        // --- SCENARIO 3: UNHAPPY (Verlopen reis) ---
        $boekingExpired = Boeking::create([
            'user_id' => $admin->id,
            'klant_id' => $klant->id,
            'reis_id' => $verledenReis->id,
            'accommodatie_id' => $acc->id,
            'num_people' => 1,
            'booking_date' => Carbon::now()->subMonths(3)->format('Y-m-d'),
            'status' => 'confirmed'
        ]);
        \App\Models\Factuur::create([
            'boeking_id' => $boekingExpired->id,
            'invoice_number' => 'INV-EXPIRED-' . $boekingExpired->id,
            'amount' => 800.00,
            'due_date' => Carbon::now()->subMonths(3)->addDays(14)->format('Y-m-d'),
            'status' => 'unpaid',
        ]);
    }
}
