<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllBoekingen;");
        DB::unprepared("
            CREATE PROCEDURE GetAllBoekingen()
            BEGIN 
                SELECT b.*, 
                       k.name as klant_name, 
                       r.title as reis_title, 
                       r.start_date as reis_start_date, 
                       a.name as acc_name, 
                       u.name as user_name, 
                       f.status as invoice_status
                FROM boekingen b
                JOIN klanten k ON b.klant_id = k.id
                JOIN reizen r ON b.reis_id = r.id
                JOIN accommodaties a ON b.accommodatie_id = a.id
                JOIN users u ON b.user_id = u.id
                LEFT JOIN facturen f ON b.id = f.boeking_id
                ORDER BY b.booking_date DESC;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't need to revert for this small UI update
    }
};
