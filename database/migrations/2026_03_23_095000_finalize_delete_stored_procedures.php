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
        // 1. DeleteKlant: Prevent if there are bookings
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteKlant;");
        DB::unprepared("
            CREATE PROCEDURE DeleteKlant(IN p_id BIGINT)
            BEGIN
                DECLARE count_bookings INT;
                SELECT COUNT(*) INTO count_bookings FROM boekingen WHERE klant_id = p_id;
                
                IF count_bookings > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Klant kan niet worden verwijderd omdat er nog actieve boekingen zijn.';
                ELSE
                    DELETE FROM klanten WHERE id = p_id;
                END IF;
            END;
        ");

        // 2. DeleteReis: Prevent if started
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteReis;");
        DB::unprepared("
            CREATE PROCEDURE DeleteReis(IN p_id BIGINT)
            BEGIN
                DECLARE v_start_date DATE;
                SELECT start_date INTO v_start_date FROM reizen WHERE id = p_id;
                
                IF v_start_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een reis die al gestart is kan niet worden verwijderd.';
                ELSE
                    DELETE FROM reizen WHERE id = p_id;
                END IF;
            END;
        ");

        // 3. DeleteAccommodatie: Prevent if there are bookings
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteAccommodatie;");
        DB::unprepared("
            CREATE PROCEDURE DeleteAccommodatie(IN p_id BIGINT)
            BEGIN
                DECLARE count_bookings INT;
                SELECT COUNT(*) INTO count_bookings FROM boekingen WHERE accommodatie_id = p_id;
                
                IF count_bookings > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Accommodatie kan niet worden verwijderd omdat er nog boekingen voor zijn.';
                ELSE
                    DELETE FROM accommodaties WHERE id = p_id;
                END IF;
            END;
        ");

        // 4. DeleteBoeking: Prevent if invoice is paid
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteBoeking;");
        DB::unprepared("
            CREATE PROCEDURE DeleteBoeking(IN p_id BIGINT)
            BEGIN
                DECLARE v_status VARCHAR(50);
                SELECT status INTO v_status FROM facturen WHERE boeking_id = p_id;
                
                IF v_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een boeking met een betaalde factuur kan niet worden verwijderd.';
                ELSE
                    -- Delete related facturen first (since it's a child)
                    DELETE FROM facturen WHERE boeking_id = p_id;
                    DELETE FROM boekingen WHERE id = p_id;
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ...
    }
};
